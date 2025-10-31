<script type="text/javascript">
	$(function(){
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
		$("#txtsearchProspects").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){
				$("#leadspages").val("1");
				tblleadslist();
			}else if(x == '8'){
                if($('#txtsearchProspects').val() == ""){
					$("#leadspages").val("1");
                    tblleadslist();
                }
            }
		});
		$("#leadspages").val("1");
	    tblleadslist();
	})

	function tblleadslist(){
	    var page = $("#leadspages").val();
	    var key = $("#txtsearchProspects").val();
		$.ajax({
			type: 'POST',
			url: 'leads/prospects/class.php',
			data: 'key=' + key + '&page=' + page + '&form=tblleadslist',
			beforeSend : function() {
	            $('#indexloadingscreen').addClass('myspinner');
	        },
	        success: function(data){
	            $('#indexloadingscreen').removeClass('myspinner');
	            if(data != ""){
	                $("#tblleadslist").html(data);
	            }else{
	                $("#tblleadslist").html("<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>");
	            }
	            loadleadsentries();
				loadleadspage();
			}
		})
	}

	function loadleadsentries(){
	    var page = $("#leadspages").val();
	    var key = $("#txtsearchProspects").val();
	    $.ajax({
	        type: 'POST',
	        url: 'leads/prospects/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadleadsentries',
	        success: function(data){
	            if(data == "no data"){
	                $("#txtleadsentries").text("");
	            }else{
	                $("#txtleadsentries").text(data);
	            }
	        }
	    });
	}

	function loadleadspage(){
	    var page = $("#leadspages").val();
	    var key = $("#txtsearchProspects").val();
	    $.ajax({
	        type: 'POST',
	        url: 'leads/prospects/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadleadspage',
	        success: function(data){
	            $("#ulpaginationleads").html(data);
	        }
	    });
	}

	function paginationpros(page, pagenums){
	    $(".pgnumleads").removeClass("active");
	    $("#pgleads" + pagenums).addClass("active");
	    $("#leadspages").val(page);
	    tblleadslist();
	}

	function showmodal_newactivity(leadsid, leadname){
		$("#frmactivityLeadsID").val(leadsid);
		$("#txtLeadsActivityLead").text(leadname);
		$("#leadsactivityattachmentcount").val("1");
		$("#modal_newactivity").modal("show");
		$("#leads_activityattachment").html("<div class='row form-group'><div class='col-md-2'><b>Attachment</b></div> <div class='col-md-5'><input type='file' class='leadsactivityattachment' id='memoattachment1' name='leadsactivityattachment1'></div></div>");
		$('.leadsactivityattachment').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});
		$("#btnSavingActivity").attr("onclick", "btnSaveNewLeadsActivity('Add')");
	}

	function appendleadsactivityattachment(){
    	var count = $("#leadsactivityattachmentcount").val();
		count = Number(count) + 1;
		$("#leads_activityattachment").append("<div class='row form-group'><div class='col-md-2'><b>Attachment</b></div><div class='col-md-5'><input type='file' class='leadsactivityattachment' id='memoattachment"+count+"' name='leadsactivityattachment"+count+"'></div></div>");
		$('.leadsactivityattachment').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});
		$("#leadsactivityattachmentcount").val(count);
    }

	function hideshowmodal_newactivity(){
		$("#modal_newactivity").modal("hide");
		$("#modal_newactivity :input").val("");
		tblleadslist();
	}

	function btnSaveNewLeadsActivity(action){
		$("#preloadmodalactivity").addClass("myspinner");
		var leadsid = $("#frmactivityLeadsID").val();
		var Lead = $("#txtLeadsActivityLead").text();
		var Subject = $("#txtLeadsActivitySubject").val();
		var Remarks = $("#txtLeadsActivityRemarks").val();
		var ActDate = $("#txtLeadsActivityDate").val();
		var ActTime = $("#txtLeadsActivityTime").val();
		var ActID = $("#frmactivityid").val();
		var attachment = "";
		$("#leads_activityattachment .leadsactivityattachment").each(function(){
			attachment += $(this).val().replace("C:\\fakepath\\", "")+"|";
		});
		if(ActDate == "" || ActTime == ""){
			setTimeout(function(){
				showmodal("alert", "Please indicate the date and time of the activity", "", null, "", null, "1");
        	}, 1000)
			$("#preloadmodalactivity").removeClass("myspinner");
		}else{
			if(action == "Add"){
				$.ajax({
					type: 'POST',
					url: 'leads/prospects/class.php',
					data: 'leadsid=' + leadsid + '&Lead=' + Lead + '&Subject=' + Subject + '&Remarks=' + Remarks + '&ActDate=' + ActDate + '&ActTime=' + ActTime + '&attachment=' + attachment + '&form=btnSaveNewLeadsActivity',
					success:function(data){
						$("#preloadmodalactivity").removeClass("myspinner");
						var arr = data.split("|");
						if(arr[0] == "1"){
				        	$("#frmactivityid").val(arr[2]);
							setTimeout(function(){
								showmodal("alert", arr[1], "hideshowmodal_newactivity", null, "", null, "0");
				        		savefrmLeadsActivity();
				        	}, 1000)
						}else{
							setTimeout(function(){
								showmodal("alert", arr[1], "", null, "", null, "1");
				        	}, 1000)
						}
					}
				})
			}else{
				$.ajax({
					type: 'POST',
					url: 'leads/prospects/class.php',
					data: 'leadsid=' + leadsid + '&ActID=' + ActID + '&Subject=' + Subject + '&Remarks=' + Remarks + '&ActDate=' + ActDate + '&ActTime=' + ActTime + '&leadsid=' + leadsid + '&attachment=' + attachment + '&form=btnUpdateLeadsActivity',
					success:function(data){
						$("#preloadmodalactivity").removeClass("myspinner");
						var arr = data.split("|");
						if(arr[0] == "1"){
							setTimeout(function(){
								showmodal("alert", arr[1], "hideshowmodal_newactivity", null, "", null, "0");
				        		savefrmLeadsActivity();
				        	}, 1000)
						}else{
							setTimeout(function(){
								showmodal("alert", arr[1], "", null, "", null, "1");
				        	}, 1000)
						}
					}
				})
			}
		}
	}

	function savefrmLeadsActivity(){
    	var data = new FormData($('#frmLeadsActivity')[0]);
		$.ajax({
	        type: 'POST',
	        url: 'leads/savefrmLeadsActivity.php',
	        data: data,
	        mimeType: 'multipart/form-data',
	        contentType: false,
	        cache: false,
	        processData: false,
	        success:function(data){

	        }
	    })
	}

	function EditActivity(ActivityID){
		$("#modal_newactivity").modal("show");
		$("#btnSavingActivity").attr("onclick", "btnSaveNewLeadsActivity('Edit')");
		$("#frmactivityid").val(ActivityID);
		$.ajax({
			type: 'POST',
			url: 'leads/prospects/class.php',
			data: 'ActivityID=' + ActivityID + '&form=EditActivity',
			success:function(data){
				var arr = data.split("|");
				$("#txtLeadsActivityLead").text(arr[0]);
				$("#txtLeadsActivitySubject").val(arr[1]);
				$("#txtLeadsActivityRemarks").val(arr[2]);
				$("#txtLeadsActivityDate").val(arr[3]);
				$("#txtLeadsActivityTime").val(arr[4]);
				$("#leads_activityattachment").html(arr[5]);
				$("#frmactivityLeadsID").val(arr[6]);
				$('.leadsactivityattachment').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false
				});
			}
		})
		$("#leadsactivityattachmentcount").val("1");
	}

	function saveProspectsFilter(){
	    var module = "Prospects";
	    var checked = "";
	    $('input:checkbox[name="form-field-leadsearch"]').each(function(){
	        if($(this).is(":checked")){
	            var value = $(this).attr("value");
	            checked += value + "|";
	        }
	    })
	    var checked2 = "";
	    $('input:checkbox[name="form-field-leadsearch"]').each(function(){
	            var value2 = $(this).attr("value");
	            checked2 += value2 + "|";
	    })
	    var checked3 = "";
	    $('input:checkbox[name="form-field-checkbox-leadStat"]').each(function(){
	        if($(this).is(":checked")){
	            var value3 = $(this).attr("value");
	            checked3 += value3 + "|";
	        }
	    })        
	    var Date1 = $("#LeadsDateFrom").val();
	    var Date2 = $("#LeadsDateTo").val();
	    $.ajax({
	        type: 'POST',
	        url: 'filter/class.php',
	        data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
	        success: function(data){
	            tblleadslist();
	            $("#LINK_Prospect_filter").click();
	        }
	    })
	}

	function loadProspectFilter(module){
	    $.ajax({
	        type: 'POST',
	        url: 'filter/class.php',
	        data: 'module=' + module + '&form=loadFilters',
	        success: function(data){
	            var datas = data.split("#");
	            var arr = datas[0].split("|");
	            var arr2 = datas[1].split("|");
	            var arr3 = datas[2].split("|");
	            for(var i=0; i<=arr.length-1; i++){
	                $('input:checkbox[id="filter_'+arr[i]+'"][value="'+arr[i]+'"]').attr('checked', 'checked');
	            }
	            $("#LeadsDateFrom").val(arr2[0]);
	            $("#LeadsDateTo").val(arr2[1]);
	            for(var i=0; i<=arr3.length-1; i++){
	                $('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
	            }
	        }
	    })
	}

	function btnJunkLead(leadsID){
        showmodal("confirm", "Are you sure you want to send this lead to junk?", "btnJunkLead2", leadsID+"|", "", null, "1");
	}

	function btnJunkLead2(leadsID){
		$.ajax({
			type: 'POST',
			url: 'leads/prospects/class.php',
			data: 'leadsID=' + leadsID + '&form=btnJunkLead',
			success:function(data){
				var arr = data.split("|");
				if(arr[0] == "1"){
					setTimeout(function(){
						showmodal("alert", arr[1], "HideLeadsMainModal", null, "", null, "0");
		        	}, 1000)
				}else{
					setTimeout(function(){
						showmodal("alert", arr[1], "", null, "", null, "1");
		        	}, 1000)
				}
			}
		})
	}

	function btnReinstateLead(leadsID){
        showmodal("confirm", "Are you sure you want to reinstate this lead?", "btnReinstateLead2", leadsID+"|", "", null, "1");
	}

	function btnReinstateLead2(leadsID){
		$.ajax({
			type: 'POST',
			url: 'leads/prospects/class.php',
			data: 'leadsID=' + leadsID + '&form=btnReinstateLead',
			success:function(data){
				var arr = data.split("|");
				if(arr[0] == "1"){
					setTimeout(function(){
						showmodal("alert", arr[1], "HideLeadsMainModal", null, "", null, "0");
		        	}, 1000)
				}else{
					setTimeout(function(){
						showmodal("alert", arr[1], "", null, "", null, "1");
		        	}, 1000)
				}
			}
		})
	}
</script>