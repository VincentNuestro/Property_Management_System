<script type="text/javascript">
	$(function(){
		$("#txtfilemonitoringpages").val("1");
    	$(".fixTable").tableHeadFixer(); 
		sycndata();
		modal_opensettingTIme();
		$("#tenantName").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtfilemonitoringpages").val("1");
				sycndata(); 
			}else if(x == '8'){
                if($('#tenantName').val() == ""){
					$("#txtfilemonitoringpages").val("1");
                    sycndata();
                }
            }
		});
		$("#txtSchedSearchPenalty").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				fncPenaltyList(); 
			}else if(x == '8'){
                if($('#txtSchedSearchPenalty').val() == ""){
                    fncPenaltyList();
                }
            }
		});

		$(function(){
			$('.btnsortdash-filemonitoring').click(function(){
				if($(this).hasClass("fa-sort-up")){
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#FileMonitoringSortType").val("ASC");
					$("#FileMonitoringSortBy").val(this.id);
					sycndata();
				}
				else if($(this).hasClass("fa-sort-down")){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#FileMonitoringSortType").val("DESC");
					$("#FileMonitoringSortBy").val(this.id);
					sycndata();
				}else if($(this).hasClass("fa-sort")){
					if($("#FileMonitoringSortType").val() == "ASC"){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#FileMonitoringSortType").val("DESC");
						$("#FileMonitoringSortBy").val(this.id);
						sycndata();
					}else{
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#FileMonitoringSortType").val("ASC");
						$("#FileMonitoringSortBy").val(this.id);
						sycndata();
					}
				}
			});
		});
	})

	setTimeout(function(){
		$('[data-rel=tooltip]').tooltip();
  		$('[data-rel=popover]').popover({html:true});
		sycndata();

		$(".date-picker").datepicker({
			autoHide: true,
			format: 'mm/dd/yyyy',
			todayHighlight: true
		})

		$('.numbers').keypress(function(event) {
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57 || event.which == 44 )){
				event.preventDefault();
			}
		}); 

		$(".numbers").blur(function(){
			var amount = $(this).val();
			$(this).val(currency(amount)); 
		})
	}, 1000)

	function currency(price){
		$.ajax ({
			type: 'POST',
			url: 'monitoring/class.php',
			async: false,
			data: 'amount=' + price + '&form=numLayout',
			success: function(data) {
				amount2 = data; 
			}
		}) 
		return amount2;
	}

	function sycndata(){
		var FileMonitoringSortBy = $('#FileMonitoringSortBy').val();
		var FileMonitoringSortType = $('#FileMonitoringSortType').val();
		var key = $("#tenantName").val();
		var dateFrom = $("#dateFrom").val();
		var dateTo = $("#dateTo").val();
		var page = $("#txtfilemonitoringpages").val();
		$.ajax({
			type: 'POST',
			url: 'monitoring/class.php',
			data: 'key=' + key + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&page=' + page + '&FileMonitoringSortBy=' + FileMonitoringSortBy + '&FileMonitoringSortType=' + FileMonitoringSortType + '&form=syncbody',
			beforeSend : function() {
	            $('#indexloadingscreen').addClass('myspinner');
	        },
	        success: function(data){
	            $('#indexloadingscreen').removeClass('myspinner');
				$("#syncbody").html(data);
				if(data != ""){
		          	$("#syncbody").html(data);
		        }else{
		          	$("#syncbody").html("<tr><td colspan='9' style='text-align: center;'>No Data Found...</td></tr>");
		        }
		        $("#syncbody tr").each(function(){
		        	if($(this).hasClass("NotMe")){

		        	}else{
		        		$(this).click(function(){
							eto = $(this).find(".mgacheckbox");
							if(eto.is(":checked")){
								eto.prop("checked", false);
								$(this).removeClass("selected");
							}else{
								eto.prop("checked", true);
								$(this).addClass("selected");
							}
						})
		        	}
				})
				loadfilemonitoringentries();
				loadpagefilemonitoring();
				DeleteCSVFromSFTP();
			}
		})
	}

	function loadfilemonitoringentries(){
      	var key = $("#tenantName").val();
      	var page = $("#txtfilemonitoringpages").val();
        $.ajax({
            type: 'POST',
            url: 'monitoring/class.php',
            data: 'key=' + key + '&page=' + page + '&form=loadfilemonitoringentries',
            success: function(data){
                if(data == ""){
                    $("#txtfilemonitoringenties").html("");
                }else{
                    $("#txtfilemonitoringenties").text(data);
                }
            }
        });
    }

    function loadpagefilemonitoring(){
	    var page = $("#txtfilemonitoringpages").val();
      	var key = $("#tenantName").val();
	    $.ajax({
	        type: 'POST',
	        url: 'monitoring/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadpagefilemonitoring',
	        success: function(data){
	            $("#ulfilemonitoringpagination").html(data);
	        }
	    });
	}

	function paginationfilemonitoring(page, pagenums){
	    $(".pgnumpfilemonitoring").removeClass("active");
	    $("#pgfilemonitoring" + pagenums).addClass("active");
	    $("#txtfilemonitoringpages").val(page);
	    $("#maincheckbox").prop("checked", false);
	    sycndata();
	}

	function saveTime(){
		var filesyncsetup = $("#txtFileSyncType").val();
		var CSVSource = $("#slcCSVSource").val();
		var wholeTime = $("#hours").val() + ":" + $("#mins").val() + " " + $("#ampm").val();
		var oras = $("#hours").val();
		var minuto = $("#mins").val();
		var ewan = $("#ampm").val();
		var dateFromsync = $("#dateFromsync").val();
		var dateTosync = $("#dateTosync").val();
		var synctype = "";
		var penalty = $("#UnsyncPenalty").val();
		$(".synctype").each(function(){
        	if($(this).prop("checked")){
            	synctype = $(this).val();
	        }
	    })
		$.ajax ({
			type: 'POST',
			url: 'monitoring/class.php',
			data: 'dateFromsync=' + dateFromsync + '&dateTosync=' + dateTosync + '&synctype=' + synctype + '&wholeTime=' + wholeTime + '&oras=' + oras + '&minuto=' + minuto + '&ewan=' + ewan + '&filesyncsetup=' + filesyncsetup + '&penalty=' + penalty + '&CSVSource=' + CSVSource + '&form=saveTime2',
			success: function(data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Setup has been saved.", "modal_closesettingTIme", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to save setup.", "", null, "", null, "0");
					}, 500)
				}
			}
		})
	}

	function modal_closesettingTIme(){
		$("#settingTIme").modal("hide");
		modal_opensettingTIme();
		sycndata();
	}

	function modal_opensettingTIme(){
		$.ajax ({
			type: 'POST',
			url: 'monitoring/class.php',
			data: 'form=getTimeSync',
			success: function(data) {
				var arr = data.split("|");
				$("#hours").val(arr[0]);
				$("#mins").val(arr[1]);
				$("#ampm").val(arr[2]);
				$("#dateFromsync").val(arr[3]);
				$("#dateTosync").val(arr[4]);
				$(".synctype").each(function(){
					if($(this).val() == arr[5]){ 
						$(this).prop("checked", true); 
					}
				});
				$("#txtFileSyncType").val(arr[6]);
				if(arr[6] == "1"){
					$("#FileSyncAuto").css("display", "none");
				}else{
					$("#FileSyncAuto").css("display", "block");
				}
				$("#UnsyncPenalty").val(arr[7]);
				$("#slcCSVSource").val(arr[8]);
			}
		})
	}

	function savecsv(){
		$.ajax({
			type: 'POST',
			url: 'monitoring/class.php',
			data: 'form=getSetupInfo',
			success:function(data){
				var arr = data.split("|");
				var SyncType = arr[0]; // Auto or Manual
				var DateFrom = arr[1];
				var DateTo = arr[2];
				var PathSetup = arr[3]; //Local or SFTP
				if(PathSetup == ""){
					setTimeout(function(){
						showmodal("alert", "No file path setup found.", "", null, "", null, "1");
					}, 100)
				}else{
					if(PathSetup == "SFTP"){
						if(SyncType == "1"){
							UploadCSVSFTPDR(DateFrom, DateTo);
						}else{
							UploadCSVSFTPToday();
						}
					}else{
						if(SyncType == "1"){
							UploadCSVLocalDR(DateFrom, DateTo);
						}else{
							UploadCSVLocalToday();
						}
					}
				}
			}
		})
	}

	function UploadCSVSFTPToday(){
		$.ajax ({
			type: 'POST',
			url: 'monitoring/syncclassSFTP.php',
			data: 'form=importcsvtoday',
			beforeSend: function() {
				$("#loadingSync").modal("show");
			},
			success: function(data) {
				$("#loadingSync").modal("hide");
				var arr = data.split("|");
				if(arr[0] == "1"){
					setTimeout(function(){
						showmodal("alert", "Files Successfully Synced.", "sycndata", null, "", null, "0");
					}, 500)
				}else if(arr[0] == "2"){
					setTimeout(function(){
						showmodal("alert", "Files for this date has already been synced.", "", null, "", null, "1");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to upload CSV.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function UploadCSVSFTPDR(DateFrom, DateTo){
		$.ajax({
			type: 'POST',
			url: 'monitoring/syncclassSFTP.php',
			data: 'dateFrom=' + DateFrom + '&dateTo=' + DateTo + '&form=importcsvdaterange',
			beforeSend: function() {
				$("#loadingSync").modal("show");
			},
			success:function(data){
				$("#loadingSync").modal("hide");
				var arr = data.split("|");
				if(arr[0] == "1"){
					setTimeout(function(){
						showmodal("alert", "Files Successfully Synced.", "sycndata", null, "", null, "0");
					}, 500)
				}else if(arr[0] == "2"){
					setTimeout(function(){
						showmodal("alert", "Files for this date has already been synced.", "sycndata", null, "", null, "1");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to upload CSV.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function UploadCSVLocalToday(){
		$.ajax ({
			type: 'POST',
			url: 'monitoring/syncclassLocal.php',
			data: 'form=importcsvtoday',
			beforeSend: function() {
				$("#loadingSync").modal("show");
			},
			success: function(data) {
				$("#loadingSync").modal("hide");
				var arr = data.split("|");
				if(arr[0] == "1"){
					setTimeout(function(){
						showmodal("alert", "Files Successfully Synced.", "sycndata", null, "", null, "0");
					}, 500)
				}else if(arr[0] == "2"){
					setTimeout(function(){
						showmodal("alert", "Files for this date has already been synced.", "", null, "", null, "1");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to upload CSV.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function UploadCSVLocalDR(DateFrom, DateTo){
		$.ajax ({
			type: 'POST',
			url: 'monitoring/syncclassLocal.php',
			data: 'dateFrom=' + DateFrom + '&dateTo=' + DateTo + '&form=importcsvdaterange',
			beforeSend: function() {
				$("#loadingSync").modal("show");
			},
			success: function(data) {
				$("#loadingSync").modal("hide");
				var arr = data.split("|");
				if(arr[0] == "1"){
					setTimeout(function(){
						showmodal("alert", "Files Successfully Synced.", "sycndata", null, "", null, "0");
					}, 500)
				}else if(arr[0] == "2"){
					setTimeout(function(){
						showmodal("alert", "Files for this date has already been synced.", "sycndata", null, "", null, "1");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to upload CSV.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function DeleteCSVFromSFTP(){
		$.ajax({
			type: 'POST',
			url: 'monitoring/syncclassSFTP.php',
			data: 'form=deletethis',
			success:function(data){
				
			}
		})
	}

	function saveFileMonitoringFilter(){
	    var module = "FileMonitoring";
	    var checked = "";
	    $('input:checkbox[name="form-field-checkboxtradename"]').each(function(){
	        if($(this).is(":checked")){
	            var value = $(this).attr("value");
	            checked += value + "|";
	        }
	    })
	    var checked2 = "";
	    $('input:checkbox[name="form-field-checkboxtradename"]').each(function(){
	            var value2 = $(this).attr("value");
	            checked2 += value2 + "|";
	    })
	    var checked3 = "";
	    $('input:checkbox[name="form-field-checkbox-csvcount"]').each(function(){
	        if($(this).is(":checked")){
	            var value3 = $(this).attr("value");
	            checked3 += value3 + "|";
	        }
	    })
	    var xcheck = "";
	    $('input:checkbox[name="form-field-TenantStatus"]').each(function(){
	        if($(this).is(":checked")){
	            var value4 = $(this).attr("value");
	            xcheck += value4 + "|";
	        }
	    })
	    var Date1 = $("#transdatefrom").val();
	    var Date2 = $("#transdateto").val();
	    $.ajax({
	        type: 'POST',
	        url: 'filter/class.php',
	        data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&xcheck=' + xcheck + '&form=saveFilters',
	        success: function(data){
	            $("#LINK_FileMonitoring_filter").click();
	            sycndata();
	        }
	    })
	}

	function loadFileMonitoringFilter(module){
	    $.ajax({
	        type: 'POST',
	        url: 'filter/class.php',
	        data: 'module=' + module + '&form=loadFilters',
	        success: function(data){
	            var datas = data.split("#");
	            var arr = datas[0].split("|");
	            var arr2 = datas[1].split("|");
	            var arr3 = datas[2].split("|");
	            var arr4 = datas[3].split("|");
	            for(var i=0; i<=arr.length-1; i++){
	                $('input:checkbox[id="filter_'+arr[i]+'"][value="'+arr[i]+'"]').attr('checked', 'checked');
	            }
	            $("#transdatefrom").val(arr2[0]);
	            $("#transdateto").val(arr2[1]);
	            for(var i=0; i<=arr3.length-1; i++){
	                $('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
	            }
	            for(var i=0; i<=arr4.length-1; i++){
	                $('input:checkbox[id="filter_'+arr4[i]+'"][value="'+arr4[i]+'"]').attr('checked', 'checked');
	            }
	        }
	    })
	}

	function tsekanlahat(){
		$("#maincheckbox").each(function(){
			if($(this).is(":checked")){
				$(".mgacheckbox").prop("checked", true);
				$("#syncbody tr").each(function(){
		        	if($(this).hasClass("NotMe")){
						$(this).removeClass("selected");
		        	}else{
						$(this).addClass("selected");
		        	}
				})
			}else{
				$(".mgacheckbox").prop("checked", false);
				$("#syncbody tr").removeClass("selected");
			}
		});
	}

	function postPenalty(){
		var count = 0;
		var TobePosted = "";
		$(".mgacheckbox").each(function(){
			if($(this).is(":checked")){
				TobePosted += $(this).attr("id")+"|";
				count++;
			}
		})
		if(TobePosted == ""){
			setTimeout(function(){
				showmodal("alert", "No record selected.", "", null, "", null, "1");
			}, 500)
		}else{
			if(count == 1){
				$("#mdlPenaltyList").modal("show");
				$.ajax({
					type: 'POST',
					url: 'monitoring/class.php',
					data: 'TobePosted=' + TobePosted + '&form=getCurrentlyPosted',
					success: function(data){
						$("#txtCheckedPenalties").val(data);
					},
					complete: function(){
						fncPenaltyList();
					}
				})
			}else{
				setTimeout(function(){
					showmodal("confirm", "You are about to post penalties to multiple tenants by doing so this will not replace currently posted penalties and will add only new penalties selected.", "PostPenaltyMulti", null, "", null, "1");
				}, 500)
			}
		}
	}

	function PostPenaltyMulti(){
		$("#mdlPenaltyList").modal("show");
		fncPenaltyList();
		$("#txtCheckedPenalties").val("");
	}

	function fncPenaltyList(){
		var key = $("#txtSchedSearchPenalty").val();
		$.ajax({
			type: 'POST',
			url: 'monitoring/class.php',
			data: 'key=' + key + '&form=postPenalty',
			success: function(data){
				$("#tblPenaltyList").html(data);
				$("#tblPenaltyList tr").each(function(){
					$(this).click(function(){
						eto = $(this).find(".chkPenaltyCode");
						if(eto.is(":checked")){
							var ids = $("#txtCheckedPenalties").val();
							eto.prop("checked", false);
							$("#txtCheckedPenalties").val(ids.replace($(this).find(".chkPenaltyCode").val() + "|", ""));
							$(this).removeClass("selected");
						}else{
							var ids = $("#txtCheckedPenalties").val();
							eto.prop("checked", true);
							ids += $(this).find(".chkPenaltyCode").val() + "|";
							$("#txtCheckedPenalties").val(ids);
							$(this).addClass("selected");
						}
					})	
				})	
			},
			complete: function(){
				var allselected = $("#txtCheckedPenalties").val();
				var arr = allselected.split("|");
				for(var a = 0; a <= arr.length-2; a++ ){
					$(".chkPenaltyCode" + arr[a]).prop("checked", true);
					$("#trr"+arr[a]).addClass("selected");
				}
			}
		})
	}

	function fncPostPenalties(){
		var ToBePosted = "";
		$(".mgacheckbox").each(function(){
			if($(this).is(":checked")){
				ToBePosted += $(this).attr("id")+"|";
			}
		})
		var chkPenalties = "";
		$(".chkPenaltyCode").each(function(){
			if($(this).is(":checked")){
				chkPenalties += $(this).attr("id") + "|";
			}
		})
		$.ajax ({
			type: 'POST',
			url: 'monitoring/class.php',
			data: 'ToBePosted=' + ToBePosted + '&chkPenalties=' + chkPenalties + '&form=fncPostPenalties',
			success: function(data) {
				if(data != ""){
					$(".mgacheckbox").prop("checked", false);
					$("#maincheckbox").prop("checked", false);
					$("#mdlPenaltyList").modal("hide");
					$("#txtCheckedPenalties").val("");
					setTimeout(function(){
						showmodal("alert", "Penalty successfully posted.", "sycndata", null, "", null, "0");
					}, 500)
				}else{
					showmodal("alert", "Failed to post penalty.", "", null, "", null, "1");
				}
			}
		})
	}

	function syncfiles(refno, Source){
		if(Source == "SFTP"){
			$.ajax ({
				type: 'POST',
				url: 'monitoring/syncclassSFTP.php',
				data: 'refno=' + refno + '&form=importcsvlate',
				beforeSend: function() {
					$("#loadingSync").modal("show");
				},
				success: function(data) {
					$("#loadingSync").modal("hide");
					if(data == "8888"){
						setTimeout(function(){
							showmodal("alert", "Files for this date has already synced.", "", null, "", null, "0");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", "Files Successfully Synced.", "sycndata", null, "", null, "0");
						}, 500)
					}
				}
			})
		}else{
			$.ajax ({
				type: 'POST',
				url: 'monitoring/syncclassLocal.php',
				data: 'refno=' + refno + '&form=importcsvlate',
				beforeSend: function() {
					$("#loadingSync").modal("show");
				},
				success: function(data) {
					$("#loadingSync").modal("hide");
					if(data == "8888"){
						setTimeout(function(){
							showmodal("alert", "Files for this date has already synced.", "", null, "", null, "0");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", "Files Successfully Synced.", "sycndata", null, "", null, "0");
						}, 500)
					}
				}
			})
		}
	}

	function showmallselection(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success:function(data){
				$("#mallselect").html(data);
			}
		})
	}

	function printFMReports(){
		var dateFrom = $("#FMdateFrom").val();
		var dateTo = $("#FMdateTo").val();
		var mallid = $("#mallselect").val();
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'mallID=' + mallid + '&form=getheaderprint',
			success:function(dataasd){
				$("#template").html(dataasd);
				$.ajax({
				    type: 'POST',
				    url: 'monitoring/class.php',
				    data: 'dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&mallid=' + mallid + '&form=printFMReports',
				    success:function(data){
				      	var arr = data.split("|");
				      	$("#tblFileMonitoringPrint").html(arr[0]);
				      	$("#txtFileMonitoringPrintDateFrom").text(arr[1]);
				      	$("#txtFileMonitoringPrintDateTo").text(arr[2]);
				        var toprint = $("#txtFileMonitoringPrint").html();
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
	}

	function filesyncsetup(type){
		if(type == "0"){
			$("#FileSyncAuto").css("display", "block");
		}else{
			$("#FileSyncAuto").css("display", "none");
		}
	}
</script>