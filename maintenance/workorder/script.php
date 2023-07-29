<script type="text/javascript">
	setTimeout(function(){
	    $(".fixTable").tableHeadFixer(); 
		$("#txt_userpagejo").val("1");
	    tblworkorder();
	    $('[data-rel=tooltip]').tooltip();
	    $('[data-rel=popover]').popover({html:true});
		$(".durationsdsdsd").change(function(){
       		var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(1).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
	    });
		$(".halaga").change(function(){
       		var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });
	    $(".date-picker").datepicker({
	        autoHide: true,
	        format: 'mm/dd/yyyy',
	        todayHighlight: true
	    });
	    $(".numberlang").keydown(function (e){ 
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || 
				(e.keyCode == 65 && e.ctrlKey === true) ||  
				(e.keyCode >= 35 && e.keyCode <= 40)) { 
				return;
			} 
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
    }, 500)

	$(function(){
		$("#txtsearchmaintenance").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txt_userpagejo").val("1");
				tblworkorder(); 
			}else if(x == '8'){
                if($('#txtsearchmaintenance').val() == ""){
					$("#txt_userpagejo").val("1");
                    tblworkorder();
                }
            }
		});
		$(".radMainFixedPayment").click(function(){
			if($(this).is(":checked")){
				if($(this).attr("id") == "MainFixedPaymentYes"){
					$("#divMainFixedPayment").css("display", "block");
				}else{
					$("#divMainFixedPayment").css("display", "none");
				}
			}
		})
		$("#txtMainSearchCategory").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				loadmdl_MainCategory(); 
			}else if ( x == '8' ){
				if($('#txtMainSearchCategory').val() == ""){
					loadmdl_MainCategory();
				}
			}
		});
		$("#txtSelectSearchTask").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				fncLoadAddTask(); 
			}else if ( x == '8' ){
				if($('#txtSelectSearchTask').val() == ""){
					fncLoadAddTask();
				}
			}
		});
	});

	function tblworkorder(){
		var dateFrom = $("#dateFrom3").val();
		var dateTo = $("#dateTo3").val();
		var key = $("#txtsearchmaintenance").val();
		var page = $("#txt_userpagejo").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&key=' + key + '&page=' + page + '&form=tblworkorder',
			beforeSend: function(){
		       	$('#indexloadingscreen').addClass('myspinner');
		    },
		    success: function(data){
        		$('#indexloadingscreen').removeClass('myspinner');
        		if(data != ""){
		          	$("#tblworkorder").html(data);
		        }else{
		          	$("#tblworkorder").html("<tr><td colspan='8' style='text-align: center;'>No Data Found...</td></tr>");
		        }
		        loadentriesjo();
				loadpagejo();
		    }
		})
	}

	function loadentriesjo(){
	    var page = $("#txt_userpagejo").val();
	    var key = $("#txtsearchmaintenance").val();
	    $.ajax({
	        type: 'POST',
	        url: 'maintenance/workorder/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadentriesjo',
	        success: function(data){
	            $("#txtjoentries").text(data);
	        }
	    });
	}

	function loadpagejo(){
	    var page = $("#txt_userpagejo").val();
	    var key = $("#txtsearchmaintenance").val();
	    $.ajax({
	        type: 'POST',
	        url: 'maintenance/workorder/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadpagejo',
	        success: function(data){
	            $("#ulpaginationjo").html(data);
	        }
	    });
	}

    function paginationjo(pagejo, pagenumsjo){
        $(".pgnumjo").removeClass("active");
        $("#pgjo" + pagenumsjo).addClass("active");
        $("#txt_userpagejo").val(pagejo);
        tblworkorder();
    }

    function loadMaintenanceFilter(module){
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&form=loadFilters',
            success: function(data){
            	var datas = data.split("#");
                var arr = datas[0].split("|");
                var arr2 = datas[1].split("|");
                var arr3 = datas[2].split("|");
                $("#dateentrystart").val(arr2[0]);
				$("#dateentryend").val(arr2[1]);
                for(var i=0; i<=arr.length-2; i++){
                    $('input:checkbox[id="filter_'+arr[i]+'"][value="'+arr[i]+'"]').attr('checked', 'checked');
                }
                for(var i=0; i<=arr3.length-1; i++){
                    $('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
                }
            }
        })
    }

    function saveMaintenancefilter(){
        var module = "Maintenance";
        var checked = "";
        $('input:checkbox[name="form-field-checkboxxxxxxx"]').each(function(){
            if($(this).is(":checked")){
                var value = $(this).attr("value");
                checked += value + "|";
            }
        })

        var checked2 = "";
        $('input:checkbox[name="form-field-checkboxxxxxxx"]').each(function(){
            var value2 = $(this).attr("value");
            checked2 += value2 + "|";
        })

        var checked3 = "";
        $('input:checkbox[name="form-field-checkboxstatussssss"]').each(function(){
        	if($(this).is(":checked")){
                var value3 = $(this).attr("value");
                checked3 += value3 + "|";
            }
        })       
        var Date1 = $("#dateentrystart").val();
		var Date2 = $("#dateentryend").val();
        $.ajax({
            type: 'POST',
            url: 'filter/class.php',
            data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
            success: function(data){
                tblworkorder();
                $("#LINK_Maintenance_filter").click();
            }
        })
    }

    function fncNewWorkOrder(){
    	$("#mdlNewWorkOrder").modal("show");
        fncShowTenantList();
        fncShowUserDepartment();
        $("#txtWoTenant").val([]).trigger("change");
		$("#txtWoDepartment").val([]).trigger("change");
		$("#txtWoPersonnel").val([]).trigger("change");
		$("#txtWoRemarks").val([]).trigger("change");
		$("#tbodySelectedTask").html("");
		$("#txtWOTotalAmount").text("0.00");
		$("#chkAllPersonnel").prop("disabled", true);
		$("#chkAllPersonnel").prop("checked", false);
		$("#chkAllTenant").prop("checked", false);
		$("#txtWoTenant").prop("disabled", false);
    }

    function fncShowTenantList(){
    	$.ajax({
    		type: 'POST',
    		url: 'mainclass.php',
    		data: 'form=showTenantList',
    		success: function(data){
    			$(".searchy_select").select2();
    			$("#txtWoTenant").html(data);
    		}
    	})
    }

	function fncShowUserDepartment(){
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'form=fncShowUserDepartment',
			success: function(data){
    			$(".searchy_select2").select2();
        		$("#divDepSetHeight .select2-selection").css('height','33px');
				$("#txtWoDepartment").html(data);
				$("#txtViewWOUserDepartment").html(data);
			}, complete: function(){
    			$("#txtWoDepartment").val([]).trigger("change");
			}
		})
	}

	function fncShowPersonnel(){
		var Department = $("#txtWoDepartment").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'Department=' + Department + '&form=fncShowPersonnel',
			success: function(data){
				$("#txtWoPersonnel").html(data);
			}
		})
	}

	function fncloadSelectFilterCategory(){
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'form=fncloadSelectFilterCategory',
			success: function(data){
				$(".searchy_select").select2();
        		$("#divSelectTaskCat .select2-selection").css('height','33px');
				$("#txtWOSelectFilterCategory").html(data);
			}, complete: function(){
				$("#txtWOSelectFilterCategory").val([]).trigger("change");
			}
		})
	}

	function fncLoadAddTask(){
		var TaskIDs = "";
		$("#tbodySelectedTask tr").each(function(){
			TaskIDs += $(this).attr("id") + "|";
		})
		var key = $("#txtSelectSearchTask").val();
		var Category = $("#txtWOSelectFilterCategory").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'key=' + key + '&Category=' + Category + '&TaskIDs=' + TaskIDs + '&form=fncLoadAddTask',
			success: function(data){
				$("#tbodySelectTask").html(data);
				$("#tbodySelectTask tr").each(function(){
					$(this).click(function(){
						var MaintenanceCategory = $(this).find(".MaintenanceCategory").text();
						var TaskDescription = $(this).find(".TaskDescription").text();
						var TaskAmount = $(this).find(".TaskAmount").text();
						if($(this).find(".isReading").text() == "1" || $(this).find(".isReading").text() == "2" || $(this).find(".isReading").text() == "3"){
							isReading = "<td style='background-color: transparent;'><input type='text' class='input-sm date-picker txtCWOReq txtReadingDate' style='background-color: transparent; color: #393939;'></td>";
						}else{
							isReading = "<td></td>";
						}
						$("#tbodySelectedTask").append("<tr id=\""+ $(this).find(".TaskID").text() +"\">" +
														"<td class='TaskAmount2 hide'>"+ $(this).find(".TaskAmount2").text() +"</td>" +
														"<td>"+ MaintenanceCategory +"</td>" +
														"<td>"+ TaskDescription +"</td>" +
														isReading +
														"<td style='text-align: right;'>"+ TaskAmount +"</td>" +
													"</tr>");
						$("#"+$(this).attr("id")).remove();
						fncTotalWOAmount();
						$(".date-picker").datepicker({
					        autoHide: true,
					        format: 'mm/dd/yyyy',
					        todayHighlight: true
					    });
					})
				})
			}
		})
	}

	function fncMainCheckAll(){
        $("#tbodySelectedTask tr").addClass("selected");
	}

	function fncMainUncheckAll(){
		$("#tbodySelectedTask tr").removeClass("selected");
	}

	function fncMainDelete(){
		var Count = 0;
		$("#tbodySelectedTask tr").each(function(){
			if($(this).hasClass("selected")){
				$(this).remove();
			}
		});
		fncTotalWOAmount();
	}

	function fncCloseTaskSelection(){
		$("#tbodySelectedTask tr").each(function(){
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
		$("#mdlMainTask").modal("hide"); 
	}

	function fncTotalWOAmount(){
		var subtotal  = 0;
		$("#tbodySelectedTask tr").each(function(){
			subtotal += parseFloat($(this).find(".TaskAmount2").text());
		});
		$("#txtWOTotalAmount").text(subtotal.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
	}

	function fncCreateWorkOrder(){
		$("#btnWoSave").button('loading');
		var Tenant = $("#txtWoTenant").val();
		var Department = $("#txtWoDepartment").val();
		var Personnel = $("#txtWoPersonnel").val();
		var Remarks = $("#txtWoRemarks").val();
		var Count = 0;
		$(".txtCWOReq").each(function(){
			if($(this).val() == "" || $(this).val() == null){
                $(this).css("border-color","#f2a696");
                Count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
		})
		var TaskIDs = "";
		$("#tbodySelectedTask tr").each(function(){
			TaskIDs += $(this).attr("id") + "|" + $(this).find(".txtReadingDate").val() + "@";
		})
		var AllTenant = "";
		if($("#chkAllTenant").is(":checked")){
			AllTenant = "Yes";
		}else{
			AllTenant = "No";
		}
		var AllPersonnel = "";
		if($("#chkAllPersonnel").is(":checked")){
			AllPersonnel = "Yes";
		}else{
			AllPersonnel = "No";
		}
		if(Count == 0){
			if(TaskIDs == ""){
				$("#btnWoSave").button('reset');
				setTimeout(function(){
					showmodal("alert", "Please select task.", "", null, "", null, "1");
				}, 500)
			}else{
				$.ajax({
					type: 'POST',
					url: 'maintenance/workorder/class.php',
					data: 'Tenant=' + Tenant + '&AllTenant=' + AllTenant + '&Department=' + Department + '&Personnel=' + Personnel + '&AllPersonnel=' + AllPersonnel + '&Remarks=' + Remarks + '&TaskIDs=' + TaskIDs + '&form=fncCreateWorkOrder',
					success: function(data){
						$("#btnWoSave").button('reset');
						var arr = data.split("|");
						if(arr[0] == "1"){
							setTimeout(function(){
								showmodal("alert", arr[1], "fncCreateWorkOrderisDone", null, "", null, "0");
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
			$("#btnWoSave").button('reset');
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncCreateWorkOrderisDone(){
    	$("#mdlNewWorkOrder").modal("hide");
		tblworkorder();
		$("#txtWoTenant").val([]).trigger("change");
		$("#txtWoDepartment").val([]).trigger("change");
		$("#txtWoPersonnel").val([]).trigger("change");
		$("#txtWoRemarks").val([]).trigger("change");
		$("#tbodySelectedTask").html("");
		$("#txtWOTotalAmount").text("0.00");
	}

	function fncViewWODetails(WorkOrderID, TenantID, WOStatus, ComplaintSeriesNo){
		$("#detailedWO").modal("show");
		if(WOStatus == "Resolved"){
			$(".btnforscheduling").prop("disabled", true);
		}else{
			$(".btnforscheduling").prop("disabled", false);
		}
		$("#modaljoseries").text(WorkOrderID);
		$("#modaltenantid").text(TenantID);
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'WorkOrderID=' + WorkOrderID + '&TenantID=' + TenantID + '&form=fncViewWODetails',
			success: function(data){
				var arr = data.split("|");
				$("#imgViewWOTenantImage").attr("src", arr[0]);
				$("#imgViewWOTenantImage").attr("alt", arr[1]);
				$("#txtViewWOTradeName").text(arr[1]);
				$("#txtViewWOTenantID").text(arr[2]);
				$("#txtViewWOCompany").text(arr[3]);
				$("#txtViewWOMall").text(arr[4]);
				$("#txtViewWOContactPerson").text(arr[5]);
				$("#txtViewWOStarDate").val(arr[6]);
				$("#txtViewWOEndDate").val(arr[7]);
				$("#txtViewWOStartTime").val(arr[8]);
				$("#txtViewWOEndTime").val(arr[9]);
				$("#txtViewWOID").val(WorkOrderID);
				$("#txtViewWOStatus").val(arr[12]);
				$.ajax({
					type: 'POST',
					url: 'maintenance/workorder/class.php',
					data: 'form=fncShowUserDepartment',
					success: function(data){
		    			$(".searchy_select").select2();
        				$("#divViewWODepartment .select2-selection").css('height','33px');
						$("#txtViewWOUserDepartment").html(data);
					}, complete: function(){
						$("#txtViewWOUserDepartment").val(arr[10]).trigger("change");
						$.ajax({
							type: 'POST',
							url: 'maintenance/workorder/class.php',
							data: 'Department=' + arr[10] + '&form=fncShowPersonnel',
							success: function(data){
		    					$(".searchy_select").select2();
        						$("#divViewWODepartment .select2-selection").css('height','33px');
								$("#txtViewWOPersonnel").html(data);
							}, complete: function(){
								$("#txtViewWOPersonnel").val(arr[11].split(",")).trigger('change');
							}
						})
					}

				})
			}, complete: function(){
				fncWorkOrderBreakdown(WorkOrderID, ComplaintSeriesNo);
			}
		})
	}

	function fncSaveWOSchedule(){
		var StartDate = $("#txtViewWOStarDate").val();
		var EndDate = $("#txtViewWOEndDate").val();
		var StartTime = $("#txtViewWOStartTime").val();
		var EndTime = $("#txtViewWOEndTime").val();
		var WONumber = $("#txtViewWOID").val();
		var AssignedDepartment = $("#txtViewWOUserDepartment").val();
		var AssignedPersonnel = $("#txtViewWOPersonnel").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'StartDate=' + StartDate + '&EndDate=' + EndDate + '&StartTime=' + StartTime + '&EndTime=' + EndTime + '&WONumber=' + WONumber + '&AssignedDepartment=' + AssignedDepartment + '&AssignedPersonnel=' + AssignedPersonnel + '&form=fncSaveWOSchedule',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Work order schedule has been saved.", "tblworkorder", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to save work order schedule.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function fncWorkOrderBreakdown(WorkOrderID, ComplaintSeriesNo){
        $(".requiredforresolving").css("border-color","#D5D5D5");
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'WorkOrderID=' + WorkOrderID + '&ComplaintSeriesNo=' + ComplaintSeriesNo + '&form=fncWorkOrderBreakdown',
			beforeSend: function(){
				$('#preLoad_div_jobandtask').addClass('myspinner');
			},
			success: function(data){
				$('#preLoad_div_jobandtask').removeClass('myspinner');
				$("#div_jobandtask").html(data);
			},
			complete: function(){
				$('.MainAttachFile').ace_file_input({
		        	no_file:'No File ...',
		        	btn_choose:'Choose',
		        	btn_change:'Change',
		        	droppable:false,
		        	onchange:null,
		        	thumbnail:false
		      	});
		      	$(".numberlang").keydown(function (e){ 
					if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || 
						(e.keyCode == 65 && e.ctrlKey === true) ||  
						(e.keyCode >= 35 && e.keyCode <= 40)) { 
						return;
					} 
					if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
						e.preventDefault();
					}
				});
				$(".date-picker").datepicker({
			        autoHide: true,
			        format: 'mm/dd/yyyy',
			        todayHighlight: true
			    });
			    $(".halaga2").change(function(){
		       		var x = ($(this).val()).replace(/,/g,"");
		            var v = parseFloat(x||0);
		            $(this).val(v.toFixed(5));
		        });
			}
		})
	}

	function fncGetTotalConsumpAmount(PrevReading, CurrReading, MeterType, frmCount, MeterID){
		var ReadingDate = $("#txtReadingDate"+MeterType+frmCount).val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'PrevReading=' + PrevReading + '&CurrReading=' + CurrReading.replace(/,/g,"") + '&MeterType=' + MeterType + '&frmCount=' + frmCount + '&ReadingDate=' + ReadingDate + '&MeterID=' + MeterID + '&form=fncGetTotalConsumpAmount',
			success: function(data){
				var arr = data.split("|");
				$("#txtTC"+MeterType+frmCount).text(arr[0]);
				$("#txtAmount"+MeterType+frmCount).text(arr[1]);
				$("#txtTC"+MeterType+frmCount).css("color", arr[2]);
				if(arr[3] == "1"){
					$("#divAlert"+MeterType+frmCount).removeClass("hide");
				}else{
					$("#divAlert"+MeterType+frmCount).addClass("hide");
				}
			}
		})
	}

	function getduration(id){
		var arr = id.split("-");
		var timefrom = $("#slstarttime-"+arr[1]).val();
		var timeto = $("#slendtime-"+arr[1]).val();
		var datefrom = $("#slstartdate-"+arr[1]).val();
		var dateto = $("#slenddate-"+arr[1]).val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: '&timefrom=' + timefrom + '&timeto=' + timeto + '&datefrom=' + datefrom + '&dateto=' + dateto + '&form=getduration',
			success: function(data){
				if(data == "error" && dateto != "" && timefrom != "" && timeto != ""){
					setTimeout(function(){
						showmodal("alert", "End time must be greater than the start time.", "", null, "", null, "1");
					}, 500)
					$("#slendtime-"+arr[1]).val("");
				}else if(dateto != "" && timefrom != "" && timeto != ""){
					$("#slduration"+arr[1]).val(data);
				}
			}
		})
	}

	function cancelJO(JON){
		setTimeout(function(){
			showmodal("confirm", "Are you sure you want to delete this work order?", "cancelJO2", JON+"|", "", null, "1");
		}, 500)
	}

	function cancelJO2(deletemokokoya){
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'deletemokokoya=' + deletemokokoya + '&form=cancelJO',
			success: function(data){
				if(data == "1"){
					setTimeout(function(){
						showmodal("alert", "Work order deleted.", "tblworkorder", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
			            showmodal("alert", data, "", null, "", null, "1");
			        }, 500)
				}
			}
		})
	}


	function showschedule(catid, taskid, workorderid, header, taskstatus, id, amount){
		$("#schedlineids").val(catid+"|"+taskid+"|"+workorderid+"|"+id);
		$("#txtSchedLineAmount").val(amount);
		$("#taskschedulertext").text(header);
		$("#taskscheduler").modal("show");
		if(taskstatus == "Resolved"){
			$("#taskscheduler input").prop("disabled", true);
			$(".taskschedulerbtn").prop("disabled", true);
		}else if(taskstatus == "Pending"){
			$("#taskscheduler input").prop("disabled", false);
			$(".taskschedulerbtn").prop("disabled", false);
		}else{
			$("#taskscheduler input").prop("disabled", false);
			$(".taskschedulerbtn").prop("disabled", false);
		}
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'catid=' + catid + '&taskid=' + taskid + '&workorderid=' + workorderid + '&form=showschedule',
			success: function(data){
				var arr = data.split("|");
				$("#tbodyschedline").html(arr[0]);
				$(".schedlinestat").each(function(){
					if($(this).val() == arr[1])
					{ $(this).prop("checked", true); }
				});
			}
		})
	}

	function appendschedline(){
		var def2 = $("#determinator").val();
		var count = parseFloat(def2) + 1;
		$("#tbodyschedline").append('<tr>' +
										'<td><div class="checkbox"><label><input type="checkbox" class="ace cbschedline"><span class="lbl"></span></label></div></td>' +
                                        '<td><input type="text" class="date-picker schedline slstartdate" data-provide="datepicker" id="slstartdate-'+count+'" onchange="getduration(this.id);"></td>' +
                                        '<td><input type="text" class="date-picker schedline slenddate" data-provide="datepicker" id="slenddate-'+count+'" onchange="getduration(this.id);"></td>' +
                                        '<td><input type="time" class="schedline slstarttime schedlinetime" id="slstarttime-'+count+'" onchange="getduration(this.id);"></td>' +
                                        '<td><input type="time" class="schedline slendtime schedlinetime" id="slendtime-'+count+'" onchange="getduration(this.id);"></td>' +
                                        '<td><input type="text" size="4" class="schedline slduration numberlang" id="slduration'+count+'" disabled></td>' +
                                    '</tr>');
		$("#determinator").val(count);
	}

	function deletecheckedschedline(){
		var ctr = $('input.cbschedline:checked').size();
		if(ctr!=0){
			$("table.tblschedline .cbschedline").each(function(){
				if ( $(this).is(":checked") == true ) {
					$(this).closest('tr').remove();
				}
			});
		}else{
			setTimeout(function(){
				showmodal("alert", "Please select atleast one you want to delete.", "", null, "", null, "1");
			}, 500)	
		}
	}

	function saveschedline(){
		var ids = $("#schedlineids").val();
		var Amount = $("#txtSchedLineAmount").val().replace(/,/g,"");
		var schedline = "";
		var stat = "";
		var date1 = "";
		var date2 = "";
		var time1 = "";
		var time2 = "";
		var duration = "";
		var duration2 = "";
		$("#tblschedline tr").each(function(){
			if($(this).find(".slstartdate").val() != "" && $(this).find(".slstartdate").val() != undefined){
	        	date1 = $(this).find(".slstartdate").val();
			}
			if($(this).find(".slenddate").val() != "" && $(this).find(".slenddate").val() != undefined){
	        	date2 = $(this).find(".slenddate").val();
			}
			if($(this).find(".slstarttime").val() != "" && $(this).find(".slstarttime").val() != undefined){
	        	time1 = $(this).find(".slstarttime").val();
			}
			if($(this).find(".slendtime").val() != "" && $(this).find(".slendtime").val() != undefined){
	        	time2 = $(this).find(".slendtime").val();
			}
			if($(this).find(".slduration").val() != "" && $(this).find(".slduration").val() != undefined){
	        	duration += $(this).find(".slduration").val() + "|";
	        	duration2 = $(this).find(".slduration").val();
			}
			if(date1 != "" && date2 != "" && time1 != "" && time2 != "" && duration != "" ){
	        	schedline += date1 + "|" + date2 + "|" + time1 + "|" + time2 + "|" + duration + "#";
			}
	    })
	    $(".schedlinestat").each(function(){
	    	if ( $(this).is(":checked") == true ) {
				stat = this.value;
			}
	    })
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'ids=' + ids + '&schedline=' + schedline + '&stat=' + stat + '&duration=' + duration + '&Amount=' + Amount + '&form=saveschedline',
			success: function(data){
				var arr = data.split("|");
				if(arr[0] == "1"){
					$("#taskscheduler").modal("hide");
					setTimeout(function(){
						showmodal("alert", "Task schedule successfully updated.", "fncWorkOrderBreakdown", arr[1]+"|"+arr[2]+"|", "", null, "0");
		        	}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to save schedule.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function printJO(workorderid, TenantID, mallid){
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'TenantID=' + TenantID + '&form=printJOtenantinformation',
			success: function(data){
				$("#txtPrintWOID").text(workorderid);
				$("#txtPrintWOTenantID").text(TenantID);
				var arr = data.split("|");
				$("#txtPrintStoreName").text(arr[0]);
				$("#txtPrintContactPerson").text(arr[1]);
				$("#txtPrintContactNumber").text(arr[2]);
			}
		})
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'workorderid=' + workorderid + '&tenantid=' + TenantID + '&form=printJOjotasklistcontainer',
			success: function(data){
				$("#jotasklistcontainer").html(data);
			}, complete: function(){
				$.ajax({
					type: 'POST',
					url: 'mainclass.php',
					data: 'mallID=' + mallid + '&form=getheaderprint',
					success: function(data){
						$("#template3").html(data);
						
					}, complete: function(){
						var toprint = $("#joprintpreview").html();
			            var myheight = $(window).height();
			            var mywidth = $(window).width();
			            var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
			            popupWin.document.open();
			            popupWin.document.write("<html><head><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
			            popupWin.document.close();
					}
				})
			}
		})
	}

	function printbydaterangeJO(){
    	var datefrom = $("#jodatefrom").val();
		var dateto = $("#jodateto").val();
		var mallid = $("#printbymewo").val();
		var maintype = $("#printbymemt").val();
		var catname = $("#printbymecn").val();
		// if(mallid != "" && mallid != null){
	        $.ajax({
	        	type: 'POST',
	        	url: 'maintenance/workorder/class.php',
	        	data: 'datefrom=' + datefrom + '&dateto=' + dateto + '&mallid=' + mallid + '&maintype=' + maintype + '&catname=' + catname + '&form=printbydaterange',
	        	success: function(data){
	        		var arr = data.split("|");
	        		$("#tblmpowobodrc").html(arr[0]);
					$("#dateFromwoprint").text(arr[1]);
					$("#dateTowoprint").text(arr[2]);
	        		$.ajax({
	        			type: 'POST',
	        			url: 'mainclass.php',
	        			data: 'mallID=' + mallid + '&form=getheaderprint',
	        			success: function(data){
	        				$("#template2").html(data);
	        			},
			        	complete: function(){
			        		var toprint = $("#mpowobodrc").html();
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
        // }else{
        // 	showmodal("alert", "Please select mall.", "", null, "", null, "1");
        // }
    }

	function ViewWOdetailedcomplaint(workorderid, tenantid, csn, taskstatus, dep){
		$("#detailedWO").modal("show");
		if(taskstatus == "Resolved"){
			$(".btnforscheduling").prop("disabled", true);
		}else{
			$(".btnforscheduling").prop("disabled", false);
		}
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'workorderid=' + workorderid + '&tenantid=' + tenantid + '&csn=' + csn + '&form=ViewWOdetailed',
			success: function(data){
				var arr = data.split("|");
				$("#modaljoseries").text(workorderid);
				$("#modaltenantid").text(tenantid);
				$("#modaljostatus").text(taskstatus);
				$("#wodep").val(dep);
				$("#modalcompanyname").text(arr[0]);
				$("#modalbranchname").text(arr[2]);
				$("#modaltenantimage").attr("src", arr[5]);
				fncWorkOrderBreakdown(workorderid, csn);
				$("#widget_tenantinfo").css("display", "block");
				$("#div_nottenant").css("display", "none");
			}
		})
	}

	function resolvingofcomplaint(csn, status){
		if(status == "Resolved"){
			$("#nilalamanngpusobtn").prop("disabled", true);
		}else{
			$("#nilalamanngpusobtn").prop("disabled", false);
		}
		$("#modalresolvingofcomplaint").modal("show");
		$("#rikimaru").val(csn);
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'csn=' + csn + '&form=resolvingofcomplaint',
			success: function(data){
				$("#nilalamanngpuso").html(data);
				$(".durationsdsdsd").change(function(){
		       		var x = ($(this).val()).replace(/,/g,"");
		            var v = parseFloat(x||0);
		            $(this).val(v.toFixed(1).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
			    });
				$(".halaga").change(function(){
		       		var x = ($(this).val()).replace(/,/g,"");
		            var v = parseFloat(x||0);
		            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		        });
			    $(".date-picker").datepicker({
			        autoHide: true,
			        format: 'mm/dd/yyyy',
			        todayHighlight: true
			    });
			    $(".numberlang").keydown(function (e){ 
					if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || 
						(e.keyCode == 65 && e.ctrlKey === true) ||  
						(e.keyCode >= 35 && e.keyCode <= 40)) { 
						return;
					} 
					if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
						e.preventDefault();
					}
				});
			}
		})
	}

	function saveresolvingofcomplaint(){
		var enddate = $("#complaintenddate").val();
		var duration = $("#complaintduration").val();
		var endtime = $("#complaintendtime").val();
		var amount = $("#complaintamount").val();
		var remarks = $("#complaintremarks").val();
		var csn = $("#rikimaru").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: '&enddate=' + enddate + '&duration=' + duration + '&endtime=' + endtime + '&amount=' + amount + '&remarks=' + remarks + '&csn=' + csn + '&form=saveresolvingofcomplaint',
			success: function(data){
				if(data == "1"){
					setTimeout(function(){
						showmodal("alert", "Data has been saved.", "", null, "", null, "0");
					}, 500)
					$("#detailedWO").modal("hide");
					tblworkorder();
				}
			}
		})
	}

	function fncSaveMeterReading(Identifier, PrevReading){
		var CurrReading = $("#txtCurrentReading"+Identifier).val().replace(/,/g,"");
		if(CurrReading == "" || CurrReading == 0){
			setTimeout(function(){
				showmodal("alert", "Please enter your current reading for this meter.", "", null, "", null, "1");
        	}, 500)
		}else{
			if(parseFloat(CurrReading) >= parseFloat(PrevReading)){
				setTimeout(function(){
		  			showmodal("confirm", "Are you sure you want to save changes?", "fncSaveWOAction", Identifier+"|", "", null, "1");
				}, 500)
			}else{
				setTimeout(function(){
					showmodal("alert", "Current reading should be greater than the previous reading.", "", null, "", null, "1");
	        	}, 500)
			}
		}
	}

	function fncSaveWOAction(Identifier){
		var data = new FormData($('#postingmetereading'+Identifier)[0]);
		if($("#txtCurrentReading"+Identifier).val() != ""){
	      	$.ajax({
		        type: "POST",
		        url: "maintenance/workorder/saveimageofmanualjo.php",
		        data: data,
		        mimeType: "multipart/form-data",
		        contentType: false,
		        cache: false,
		        processData: false,
		        success: function(data){
		        	var arr = data.split("|");
		        	setTimeout(function(){
						showmodal("alert", "Meter reading saved.", "fncWorkOrderBreakdown", arr[0]+"|"+arr[1]+"|", "", null, "0");
		        	}, 500)
		        }
	      	})
      	}else{
      		setTimeout(function(){
      			showmodal("alert", "Please input meter reading value.", "", null, "", null, "0");
			}, 500)
      	}
	}

	function fncPostWorkOrder(WorkorderID){
  		setTimeout(function(){
			showmodal("confirm", "Confirm posting to billing?", "fncPostWorkOrder2", WorkorderID+"|", "", null, "1");
		}, 500)
	}

	function fncPostWorkOrder2(WorkorderID){
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: '&WorkorderID=' + WorkorderID + '&form=fncPostWorkOrder2',
			success: function(data){
				if(data >= 1){
					setTimeout(function(){
						showmodal("alert", "Maintenance charges successfully posted to billing.", "tblworkorder", null, "", null, "0");
						$("#detailedWO").modal("hide");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to post charges to billing.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function showfilterofmall(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success: function(data){
				$(".malloption").html(data);
			}
		})
	}

	function showmaincat(){
		var maintype = $("#printbymemt").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'maintype=' + maintype + '&form=showmaincat',
			success: function(data){
				$("#printbymecn").html(data);
			}
		})
	}

	function showwodep(){
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: 'form=showwodep',
			success: function(data){
				$("#wodep").html(data);
			}
		})
	}

	function showwopersonnel(){
		var dep = $("#wodep").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/workorder/class.php',
			data: '&dep=' + dep + '&form=showwopersonnel',
			success: function(data){
				$("#wopersonnel").html(data);
			}
		})
	}

	function checkfiletype(fileName, count){
		var fileExtension = "";
		fileExtension = fileName.substr((fileName.lastIndexOf('.') + 1));
		if(fileExtension != "jpeg" && fileExtension != "jpg" && fileExtension != "gif" && fileExtension != "bmp" && fileExtension != "png"){
			$("#divRemovefile"+count).find("a").click();
			setTimeout(function(){
				showmodal("alert", "Invalid file type.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncSelectAllTenant(){
		if($("#chkAllTenant").is(":checked")){
			$("#txtWoTenant").prop("disabled", true);
			$("#txtWoTenant").removeClass("txtCWOReq");
		}else{
			$("#txtWoTenant").prop("disabled", false);
			$("#txtWoTenant").addClass("txtCWOReq");
		}
	}

	function fncSelectAllPersonnel(){
		if($("#chkAllPersonnel").is(":checked")){
			// $("#txtWoPersonnel").prop("disabled", true);
			$("#txtWoPersonnel").removeClass("txtCWOReq");
		}else{
			// $("#txtWoPersonnel").prop("disabled", false);
			$("#txtWoPersonnel").addClass("txtCWOReq");
		}
	}
	
	function fncAllowSelectAll(){
		if($("#txtWoDepartment").val() == "" || $("#txtWoDepartment").val() == null){
			$("#chkAllPersonnel").prop("disabled", true);
		}else{
			$("#chkAllPersonnel").prop("disabled", false);
		}
	}
</script>