<script type="text/javascript">
	$(function(){
		loadtxtSchedRef();
	})

	function ShowSchedOption(){
		$("#mdl_SchedOption").modal("show");
		CheckModule('Billing');
	}

	function CheckModule(mdl){
		// if(mdl == 'Billing'){
		// 	$("#submdl_SchedOption").css("width" , "");
		// }else{
			$("#submdl_SchedOption").css("width" , "90%");
		// }
		fnctbodySchedMaintenance();
	}
</script>

<!-- START OF BILLING SCHEDULE SCRIPT -->
<script type="text/javascript">
	function fncSaveBillSetup(){
		var MallID = $("#txtBillSetupMall").val();
		var MonthlyRent = $("#txtBillSetupMonthlyRent").val();
		var OperationalCharges = $("#txtBillSetupOperationalCharges").val();
		var count = 0;
		$(".txtBillSetupReq").each(function(){
			if($(this).val() == ""){
				count++;
			}
		})
		if(count == 0){
			$.ajax({
				type: 'POST',
				url: 'scheduler/class.php',
				data: 'MallID=' + MallID + '&MonthlyRent=' + MonthlyRent + '&OperationalCharges=' + OperationalCharges + '&form=fncSaveBillSetup',
				success:function(data){
					if(data == "1"){
						setTimeout(function(){
							showmodal("alert", "Posting of charges setup successfully saved.", "", null, "", null, "0");
						}, 500)
					}else if(data == "2"){
						setTimeout(function(){
							showmodal("alert", "Posting of charges setup successfully updated.", "", null, "", null, "0");
						}, 500)
					}else{

					}
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function loadBillSetup(){
		var MallID = $("#txtBillSetupMall").val();
		$.ajax({
			type: 'POST',
			url: 'scheduler/class.php',
			data: 'MallID=' + MallID + '&form=loadBillSetup',
			success:function(data){
				var arr = data.split("|");
				$("#txtBillSetupMonthlyRent").val(arr[0]);
				$("#txtBillSetupOperationalCharges").val(arr[1]);
			}
		})
	}
</script>
<!-- END OF BILLING SCHEDULE SCRIPT -->

<!-- START OF MAINTENANCE SCHEDULE SCRIPT -->
<script type="text/javascript">
	$(function(){
		$("#txtMSSelectSearchTask").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				fncMSLoadAddTask(); 
			}else if ( x == '8' ){
				if($('#txtMSSelectSearchTask').val() == ""){
					fncMSLoadAddTask();
				}
			}
		});
		$(".date-picker").datepicker({
	        autoHide: true,
	        format: 'mm/dd/yyyy',
	        todayHighlight: true
	    });
	})

	function fnctbodySchedMaintenance(){
		$.ajax({
			type: 'POST',
			url: 'scheduler/class.php',
			data: 'form=fnctbodySchedMaintenance',
			success:function(data){
				$("#tbodySchedMaintenance").html(data);
			}
		})
	}

	function fncAddNewSetup(){
		$("#mdl_NewSched").modal("show");
		$("#txtSchedTenant").val([]).trigger("change");
		$("#txtSchedDepartment").val([]).trigger("change");
		$("#txtSchedPersonnel").html("<option value=''>-- Select Personnel --</option>");
		$("#txtSchedPersonnel").val([]).trigger("change");
       	$("#rdOnLoadClick").click();
		$("#divMSDepartment .select2-selection").css('height','33px');
		$(".divMSDayofTheWeek .select2-selection").css('height','33px');
		$(".divMSDateofTheMonth .select2-selection").css('height','33px');
		$("#tbodyMSSelectedTask").html("");
		$("#txtMSTotalAmount").text("0.00");
		$("#chkMSAllPersonnel").prop("disabled", true);
		$("#chkMSAllPersonnel").prop("checked", false);
		$("#chkMSAllTenant").prop("checked", false);
		$("#txtSchedTenant").prop("disabled", false);
		$("#txtSchedPersonnel").prop("disabled", false);
	}

	function fncAddNewSetupX(){
		$("#mdl_NewSched").modal("hide");
		$("#txtSchedTenant").val([]).trigger("change");
		$("#txtSchedDepartment").val([]).trigger("change");
		$("#txtSchedPersonnel").html("<option value=''>-- Select Personnel --</option>");
		$("#txtSchedPersonnel").val([]).trigger("change");
       	$("#rdOnLoadClick").click();
       	fnctbodySchedMaintenance();
       	$("#txtSchedID").val("");
       	$("#tbodyMSSelectedTask").html("");
       	$("#txtMSTotalAmount").text("0.00");
	}

	function OpenThisOnModal(SchedID){
		$("#txtSchedID").val(SchedID);
		var xPersonnel = "";
		$.ajax({
			type: 'POST',
			async: false,
			url: 'scheduler/class.php',
			data: 'SchedID=' + SchedID + '&form=loadSchedSetup',
			success:function(data){
				var arr = data.split("|");
				$("#divMSDepartment .select2-selection").css('height','33px');
				$("#txtSchedDepartment").val(arr[1]).trigger("change");
				$(".rdPeriod").each(function(){
					if($(this).val() == arr[3]){
						$(this).click();
					}
				})
				$("#txtSchedWeek1").val(arr[4]);
				$("#txtSchedWeek2").val(arr[5]);
				$("#txtSchedMonth1").val(arr[6]);
				$("#txtSchedMonth2").val(arr[7]);
				$("#txtSchedDate1").val(arr[8]);
				$("#txtSchedDate2").val(arr[9]);
				$("#txtSchedDate3").val(arr[10]);
				$("#txtSchedDate4").val(arr[11]);
				$("#txtSchedDate5").val(arr[12]);
				$("#txtSchedDate6").val(arr[13]);
				$("#txtSchedDate7").val(arr[14]);
				$("#txtSchedDate8").val(arr[15]);
				if(arr[16] == "1"){
					$("#chkMSAllTenant").prop("checked", true);
					$("#txtSchedTenant").val("").trigger('change');
					$("#txtSchedTenant").prop("disabled", true);
					$("#txtSchedTenant").removeClass("isSchedReq");
				}else{
					$("#chkMSAllTenant").prop("checked", false);
					$("#txtSchedTenant").val(arr[0].split(",")).trigger('change');
					$("#txtSchedTenant").prop("disabled", false);
					$("#txtSchedTenant").addClass("isSchedReq");
				}
				if(arr[17] == "1"){
					$("#chkMSAllPersonnel").prop("checked", true);
					$("#txtSchedPersonnel").html("");
					$("#txtSchedPersonnel").val("").trigger('change');
					$("#txtSchedPersonnel").prop("disabled", true);
					$("#txtSchedPersonnel").removeClass("isSchedReq");
				}else{
					$("#chkMSAllPersonnel").prop("checked", false);
					$("#txtSchedPersonnel").prop("disabled", true);
					$("#txtSchedPersonnel").addClass("isSchedReq");
					$.ajax({
						type: 'POST',
						url: 'scheduler/class.php',
						data: 'val=' + arr[1] + '&form=SchedPersonnel',
						success:function(data){
			    			$(".searchy_select").select2();
							$("#txtSchedPersonnel").html(data);
						}, complete: function(){
							$("#txtSchedPersonnel").val(arr[2].split(",")).trigger('change');
						}
					})
				}
			}, complete:function(){
				$("#mdl_NewSched").modal("show");
			}
		})
		$.ajax({
			type: 'POST',
			url: 'scheduler/class.php',
			data: 'SchedID=' + SchedID + '&form=loadSchedSetup2',
			success: function(data){
				$("#tbodyMSSelectedTask").html(data);
				$("#tbodyMSSelectedTask tr").each(function(){
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
			}, complete: function(){
				fncTotalMSAmount();
			}
		})
	}

	function loadtxtSchedRef(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success:function(data){
				$("#txtBillSetupMall").html(data);
			}
		})
		$.ajax({
			type: 'POST',
    		url: 'mainclass.php',
    		data: 'form=showTenantList',
    		success: function(data){
    			$(".searchy_select").select2();
    			$("#txtSchedTenant").html(data);
    		}
    	})
		$.ajax({
			type: 'POST',
			url: 'scheduler/class.php',
			data: 'form=SchedDepartment',
			success:function(data){
    			$(".searchy_select").select2();
				$("#txtSchedDepartment").html(data);
			}
		})
	}

	function fncSelectPersonnel(val){
		$.ajax({
			type: 'POST',
			url: 'scheduler/class.php',
			data: 'val=' + val + '&form=SchedPersonnel',
			success:function(data){
    			$(".searchy_select").select2();
				$("#txtSchedPersonnel").html(data);
			}
		})
	}

	function SchedChangePeriod(Period){
		if(Period == "Daily"){
			$("#isWeekly").addClass("hide");
			$("#isMonthly").addClass("hide");
			$("#txtMSSchedDate1").addClass("hide");
			$("#txtMSSchedDate2").addClass("hide");
			$("#txtMSSchedDate3").addClass("hide");
			$("#txtMSSchedDate4").addClass("hide");

			$("#isWeekly :input").val([]).trigger("change");
			$("#isMonthly :input").val([]).trigger("change");
			$("#txtMSSchedDate1 :input").val("");
			$("#txtMSSchedDate2 :input").val("");
			$("#txtMSSchedDate3 :input").val("");
			$("#txtMSSchedDate4 :input").val("");

			$("#isWeekly :input").removeClass("isSchedReq");
			$("#isMonthly :input").removeClass("isSchedReq");
			$("#txtMSSchedDate1 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate2 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate3 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate4 :input").removeClass("isSchedReq");
		}else if(Period == "Weekly"){
			$("#isWeekly").removeClass("hide");
			$("#isMonthly").addClass("hide");
			$("#txtMSSchedDate1").addClass("hide");
			$("#txtMSSchedDate2").addClass("hide");
			$("#txtMSSchedDate3").addClass("hide");
			$("#txtMSSchedDate4").addClass("hide");

			$("#isWeekly :input").val([]).trigger("change");
			$("#isMonthly :input").val([]).trigger("change");
			$("#txtMSSchedDate1 :input").val("");
			$("#txtMSSchedDate2 :input").val("");
			$("#txtMSSchedDate3 :input").val("");
			$("#txtMSSchedDate4 :input").val("");

			$("#isWeekly :input").addClass("isSchedReq");
			$("#isMonthly :input").removeClass("isSchedReq");
			$("#txtMSSchedDate1 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate2 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate3 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate4 :input").removeClass("isSchedReq");
		}else if(Period == "Monthly"){
			$("#isWeekly").addClass("hide");
			$("#isMonthly").removeClass("hide");
			$("#txtMSSchedDate1").addClass("hide");
			$("#txtMSSchedDate2").addClass("hide");
			$("#txtMSSchedDate3").addClass("hide");
			$("#txtMSSchedDate4").addClass("hide");

			$("#isWeekly :input").val([]).trigger("change");
			$("#isMonthly :input").val([]).trigger("change");
			$("#txtMSSchedDate1 :input").val("");
			$("#txtMSSchedDate2 :input").val("");
			$("#txtMSSchedDate3 :input").val("");
			$("#txtMSSchedDate4 :input").val("");

			$("#isWeekly :input").removeClass("isSchedReq");
			$("#isMonthly :input").addClass("isSchedReq");
			$("#txtMSSchedDate1 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate2 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate3 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate4 :input").removeClass("isSchedReq");
		}else if(Period == "Quarterly"){
			$("#isWeekly").addClass("hide");
			$("#isMonthly").addClass("hide");
			$("#txtMSSchedDate1").removeClass("hide");
			$("#txtMSSchedDate2").removeClass("hide");
			$("#txtMSSchedDate3").removeClass("hide");
			$("#txtMSSchedDate4").removeClass("hide");

			$("#isWeekly :input").val([]).trigger("change");
			$("#isMonthly :input").val([]).trigger("change");
			$("#txtMSSchedDate1 :input").val("");
			$("#txtMSSchedDate2 :input").val("");
			$("#txtMSSchedDate3 :input").val("");
			$("#txtMSSchedDate4 :input").val("");

			$("#isWeekly :input").removeClass("isSchedReq");
			$("#isMonthly :input").removeClass("isSchedReq");
			$("#txtMSSchedDate1 :input").addClass("isSchedReq");
			$("#txtMSSchedDate2 :input").addClass("isSchedReq");
			$("#txtMSSchedDate3 :input").addClass("isSchedReq");
			$("#txtMSSchedDate4 :input").addClass("isSchedReq");
		}else if(Period == "Biannually"){
			$("#isWeekly").addClass("hide");
			$("#isMonthly").addClass("hide");
			$("#txtMSSchedDate1").removeClass("hide");
			$("#txtMSSchedDate2").removeClass("hide");
			$("#txtMSSchedDate3").addClass("hide");
			$("#txtMSSchedDate4").addClass("hide");

			$("#isWeekly :input").val([]).trigger("change");
			$("#isMonthly :input").val([]).trigger("change");
			$("#txtMSSchedDate1 :input").val("");
			$("#txtMSSchedDate2 :input").val("");
			$("#txtMSSchedDate3 :input").val("");
			$("#txtMSSchedDate4 :input").val("");

			$("#isWeekly :input").removeClass("isSchedReq");
			$("#isMonthly :input").removeClass("isSchedReq");
			$("#txtMSSchedDate1 :input").addClass("isSchedReq");
			$("#txtMSSchedDate2 :input").addClass("isSchedReq");
			$("#txtMSSchedDate3 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate4 :input").removeClass("isSchedReq");
		}else if(Period == "Annually"){
			$("#isWeekly").addClass("hide");
			$("#isMonthly").addClass("hide");
			$("#txtMSSchedDate1").removeClass("hide");
			$("#txtMSSchedDate2").addClass("hide");
			$("#txtMSSchedDate3").addClass("hide");
			$("#txtMSSchedDate4").addClass("hide");

			$("#isWeekly :input").val([]).trigger("change");
			$("#isMonthly :input").val([]).trigger("change");
			$("#txtMSSchedDate1 :input").val("");
			$("#txtMSSchedDate2 :input").val("");
			$("#txtMSSchedDate3 :input").val("");
			$("#txtMSSchedDate4 :input").val("");

			$("#isWeekly :input").removeClass("isSchedReq");
			$("#isMonthly :input").removeClass("isSchedReq");
			$("#txtMSSchedDate1 :input").addClass("isSchedReq");
			$("#txtMSSchedDate2 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate3 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate4 :input").removeClass("isSchedReq");
		}else{
			$("#isWeekly").addClass("hide");
			$("#isMonthly").addClass("hide");
			$("#txtMSSchedDate1").addClass("hide");
			$("#txtMSSchedDate2").addClass("hide");
			$("#txtMSSchedDate3").addClass("hide");
			$("#txtMSSchedDate4").addClass("hide");

			$("#isWeekly :input").val([]).trigger("change");
			$("#isMonthly :input").val([]).trigger("change");
			$("#txtMSSchedDate1 :input").val("");
			$("#txtMSSchedDate2 :input").val("");
			$("#txtMSSchedDate3 :input").val("");
			$("#txtMSSchedDate4 :input").val("");

			$("#isWeekly :input").removeClass("isSchedReq");
			$("#isMonthly :input").removeClass("isSchedReq");
			$("#txtMSSchedDate1 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate2 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate3 :input").removeClass("isSchedReq");
			$("#txtMSSchedDate4 :input").removeClass("isSchedReq");
		}
	}

	function fncMSloadSelectFilterCategory(){
		$.ajax({
			type: 'POST',
			url: 'scheduler/class.php',
			data: 'form=fncMSloadSelectFilterCategory',
			success: function(data){
				$(".searchy_select").select2();
        		$("#divMSSelectTaskCat .select2-selection").css('height','33px');
				$("#txtMSSelectFilterCategory").html(data);
			}, complete: function(){
				$("#divMSSelectTaskCat").val([]).trigger("change");
			}
		})
	}

	function fncMSLoadAddTask(){
		var TaskIDs = "";
		$("#tbodyMSSelectedTask tr").each(function(){
			TaskIDs += $(this).attr("id") + "|";
		})
		var key = $("#txtMSSelectSearchTask").val();
		var Category = $("#divMSSelectTaskCat").val();
		$.ajax({
			type: 'POST',
			url: 'scheduler/class.php',
			data: 'key=' + key + '&Category=' + Category + '&TaskIDs=' + TaskIDs + '&form=fncMSLoadAddTask',
			success: function(data){
				$("#tbodyMSSelectTask").html(data);
				$("#tbodyMSSelectTask tr").each(function(){
					$(this).click(function(){
						var MaintenanceCategory = $(this).find(".MaintenanceCategory").text();
						var TaskDescription = $(this).find(".TaskDescription").text();
						var TaskAmount = $(this).find(".TaskAmount").text();
						$("#tbodyMSSelectedTask").append("<tr id=\""+ $(this).find(".TaskID").text() +"\">" +
														"<td class='TaskAmount2 hide'>"+ $(this).find(".TaskAmount2").text() +"</td>" +
														"<td>"+ MaintenanceCategory +"</td>" +
														"<td>"+ TaskDescription +"</td>" +
														"<td style='text-align: right;'>"+ TaskAmount +"</td>" +
													"</tr>");
						$("#"+$(this).attr("id")).remove();
						fncTotalMSAmount();
					})
				})
			}
		})
	}

	function fncMSCheckAll(){
        $("#tbodyMSSelectedTask tr").addClass("selected");
	}

	function fncMSUncheckAll(){
		$("#tbodyMSSelectedTask tr").removeClass("selected");
	}

	function fncMSDelete(){
		var Count = 0;
		$("#tbodyMSSelectedTask tr").each(function(){
			if($(this).hasClass("selected")){
				$(this).remove();
			}
		});
		fncTotalMSAmount();
	}

	function fncMSCloseTaskSelection(){
		$("#mdlMSTask").modal("hide");
		$("#tbodyMSSelectedTask tr").each(function(){
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
	}

	function fncTotalMSAmount(){
		var subtotal  = 0;
		$("#tbodyMSSelectedTask tr").each(function(){
			subtotal += parseFloat($(this).find(".TaskAmount2").text());
		});
		$("#txtMSTotalAmount").text(subtotal.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
	}

	function SaveSchedSetup(){
		$("#btnMSSave").button('reset');
		var count = 0;
		$(".isSchedReq").each(function(){
			if($(this).val() == "" || $(this).val() == null){
				count++;
			}
		})
		var SchedID = $("#txtSchedID").val();
		var TenantID = $("#txtSchedTenant").val();
		var GroupAccess = $("#txtSchedDepartment").val();
		var xPersonnel = $("#txtSchedPersonnel").val();
		var xPeriod = "";
		$(".rdPeriod").each(function(){
			if($(this).is(":checked")){
				xPeriod = $(this).val();
			}
		})
		var SchedWeek1 = $("#txtSchedWeek1").val();
		var SchedWeek2 = $("#txtSchedWeek2").val();
		var SchedMonth1 = $("#txtSchedMonth1").val();
		var SchedMonth2 = $("#txtSchedMonth2").val();
		var SchedDate1 = $("#txtSchedDate1").val();
		var SchedDate2 = $("#txtSchedDate2").val();
		var SchedDate3 = $("#txtSchedDate3").val();
		var SchedDate4 = $("#txtSchedDate4").val();
		var SchedDate5 = $("#txtSchedDate5").val();
		var SchedDate6 = $("#txtSchedDate6").val();
		var SchedDate7 = $("#txtSchedDate7").val();
		var SchedDate8 = $("#txtSchedDate8").val();
		var TaskIDs = "";
		$("#tbodyMSSelectedTask tr").each(function(){
			TaskIDs += $(this).attr("id") + "|";
		})
		var AllTenant = "";
		if($("#chkMSAllTenant").is(":checked")){
			AllTenant = "Yes";
		}else{
			AllTenant = "No";
		}
		var AllPersonnel = "";
		if($("#chkMSAllPersonnel").is(":checked")){
			AllPersonnel = "Yes";
		}else{
			AllPersonnel = "No";
		}
		if(count == 0){
			if(TaskIDs == ""){
				setTimeout(function(){
					showmodal("alert", "Please select the task associated with this schedule.", "", null, "", null, "1");
				}, 500)
			}else{
				$.ajax({
					type: 'POST',
					url: 'scheduler/class.php',
					data: 'SchedID=' + SchedID + '&TenantID=' + TenantID + '&GroupAccess=' + GroupAccess + '&xPersonnel=' + xPersonnel + '&xPeriod=' + xPeriod + '&SchedWeek1=' + SchedWeek1 + '&SchedWeek2=' + SchedWeek2 + '&SchedMonth1=' + SchedMonth1 + '&SchedMonth2=' + SchedMonth2 + '&SchedDate1=' + SchedDate1 + '&SchedDate2=' + SchedDate2 + '&SchedDate3=' + SchedDate3 + '&SchedDate4=' + SchedDate4 + '&SchedDate5=' + SchedDate5 + '&SchedDate6=' + SchedDate6 + '&SchedDate7=' + SchedDate7 + '&SchedDate8=' + SchedDate8 + '&TaskIDs=' + TaskIDs + '&AllTenant=' + AllTenant + '&AllPersonnel=' + AllPersonnel + '&form=SaveSchedSetup',
					success:function(data){
						$("#btnMSSave").button('reset');
						var arr = data.split("|");
						if(arr[0] == "1"){
							setTimeout(function(){
								showmodal("alert", arr[1], "fncAddNewSetupX", null, "", null, "0");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", arr[1], "", null, "", null, "1");
							}, 500)
						}
					}
				})
			}
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncMSSelectAllTenant(){
		if($("#chkMSAllTenant").is(":checked")){
			$("#txtSchedTenant").prop("disabled", true);
			$("#txtSchedTenant").removeClass("isSchedReq");
		}else{
			$("#txtSchedTenant").prop("disabled", false);
			$("#txtSchedTenant").addClass("isSchedReq");
		}
	}

	function fncMSSelectAllPersonnel(){
		if($("#chkMSAllPersonnel").is(":checked")){
			$("#txtSchedPersonnel").prop("disabled", true);
			$("#txtSchedPersonnel").removeClass("isSchedReq");
		}else{
			$("#txtSchedPersonnel").prop("disabled", false);
			$("#txtSchedPersonnel").addClass("isSchedReq");
		}
	}
	
	function fncMSAllowSelectAll(){
		if($("#txtSchedDepartment").val() == "" || $("#txtSchedDepartment").val() == null){
			$("#chkMSAllPersonnel").prop("disabled", true);
		}else{
			$("#chkMSAllPersonnel").prop("disabled", false);
		}
	}
</script>
<!-- END OF MAINTENANCE SCHEDULE SCRIPT -->