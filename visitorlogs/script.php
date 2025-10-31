<script type="text/javascript">
	$(function(){
		$(".fixTable").tableHeadFixer();
		$('[data-rel=tooltip]').tooltip();
		$('[data-rel=popover]').popover({html:true});
		$("#txtVisitorLogsPage").val("1");
		tblvisitorlog();
		$("#txtVisitorLogsKey").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtVisitorLogsPage").val("1");
				tblvisitorlog(); 
			}else if(x == '8'){
                if($('#txtVisitorLogsKey').val() == ""){
					$("#txtVisitorLogsPage").val("1");
                    tblvisitorlog();
                }
            }
		});

		$(function(){
			$('.btnsortdash-visitorlogs').click(function(){
				if($(this).hasClass("fa-sort-up")){
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#VisitorLogsSortType").val("ASC");
					$("#VisitorLogsSortBy").val(this.id);
					tblvisitorlog();
				}
				else if($(this).hasClass("fa-sort-down")){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#VisitorLogsSortType").val("DESC");
					$("#VisitorLogsSortBy").val(this.id);
					tblvisitorlog();
				}else if($(this).hasClass("fa-sort")){
					if($("#VisitorLogsSortType").val() == "ASC"){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#VisitorLogsSortType").val("DESC");
						$("#VisitorLogsSortBy").val(this.id);
						tblvisitorlog();
					}else{
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#VisitorLogsSortType").val("ASC");
						$("#VisitorLogsSortBy").val(this.id);
						tblvisitorlog();
					}
				}
			});
		});
	})

	function tblvisitorlog(){
		var VisitorLogsSortBy = $('#VisitorLogsSortBy').val();
		var VisitorLogsSortType = $('#VisitorLogsSortType').val();
		var key = $("#txtVisitorLogsKey").val();
	  	var page = $("#txtVisitorLogsPage").val();
		$.ajax({
			type: 'POST',
			url: 'visitorlogs/class.php',
			data: 'page=' + page + '&key=' + key +  '&VisitorLogsSortBy=' + VisitorLogsSortBy + '&VisitorLogsSortType=' + VisitorLogsSortType + '&form=tblvisitorlog',
			beforeSend : function() {
		      	$('#indexloadingscreen').addClass('myspinner');
		    },
		    success: function(data){
		     	$('#indexloadingscreen').removeClass('myspinner');
		      	if(data != ""){
		        	$("#tblvisitorlog").html(data);
		      	}else{
		        	$("#tblvisitorlog").html("<tr><td colspan='10' style='text-align: center;'>No Data Found...</td></tr>");
		      	}
		      	loadvisitlogsentries();
				loadvisitlogspagination();
			}
		})
	}

	function loadvisitlogsentries(){
	  	var page = $("#txtVisitorLogsPage").val();
	  	var key = $("#txtVisitorLogsKey").val();
	  	$.ajax({
	  	  	type: 'POST',
	  	  	url: 'visitorlogs/class.php',
	  	  	data: 'key=' + key + '&page=' + page + '&form=loadvisitlogsentries',
	  	  	success: function(data){
	  	  	  	if(data == ""){
	  	  	    	$("#txtVisitorLogsEntries").text("");
	  	  	  	}else{
	  	  	    	$("#txtVisitorLogsEntries").text(data);
	  	  	  	}
	  	  	}
	  	})
	}

	function loadvisitlogspagination(){
	  	var page = $("#txtVisitorLogsPage").val();
	  	var key = $("#txtVisitorLogsKey").val();
	  	$.ajax({
	  	  	type: 'POST',
	  	  	url: 'visitorlogs/class.php',
	  	  	data: 'key=' + key + '&page=' + page + '&form=loadvisitlogspagination',
	  	  	success: function(data){
	  	  	  	$("#ulPaginationVisitorLogs").html(data);
	  	  	}
	  	})
	}

	function paginationvisitorlogs(page, pagenums){
	  	$(".pgnumvisitlogs").removeClass("active");
	  	$("#pgvisitlogs" + pagenums).addClass("active");
	  	$("#txtVisitorLogsPage").val(page);
	  	tblvisitorlog();
	}
	
	function addnewvisitor(){
		$("#modal_addnewvisitor").modal("show");
		$("#modal_addnewvisitor :input").val("");
	}

	function closemodal(){
		$("#modal_addnewvisitor").modal("hide");
		$("#modal_addnewvisitor :input").val("");
  		$(".visitlogrequired").css("border-color","#D5D5D5");
	}

	function savenewvisitlog(){
		var VisitorID = $("#txtVisitLogVisitorID").val();
		var VisitorName = $("#txtVisitLogVisitorName").val();
		var ContactNumber = $("#txtVisitLogContactNumber").val();
		var Address = $("#txtVisitLogAddress").val();
		var PurposeofVisit = $("#txtVisitLogPurposeOfVisit").val();
		var count = 0;
		$(".visitlogrequired").each(function(){
		    if($(this).val() == ""){
		        count++;
		        $(this).css("border-color","#f2a696");
		    }else{
		      	$(this).css("border-color","#D5D5D5");
		    }
		})
  		if(count == 0){
			$.ajax({
				type: 'POST',
				url: 'visitorlogs/class.php',
				data: 'VisitorID=' + VisitorID + '&VisitorName=' + VisitorName + '&ContactNumber=' + ContactNumber + '&Address=' + Address + '&PurposeofVisit=' + PurposeofVisit + '&form=savenewvisitlog',
				beforeSend:function(){
					$("#newvisitloading").addClass('myspinner');
				},
				success:function(data){
					$("#newvisitloading").removeClass('myspinner');
					var arr = data.split("|");
			        if(arr[0] == "1"){
			          	setTimeout(function(){
			            	showmodal("alert", arr[1], "closemodal", null, "", null, "0");
			          	}, 100)
			        }else{
			        	setTimeout(function(){
			            	showmodal("alert", arr[1], "closemodal", null, "", null, "0");
			          	}, 100)
			        }
				}
			})
		}else{
		    setTimeout(function(){
		      	showmodal("alert", "Please fill all fields.", "", null, "", null, "0");
		    }, 100)
		}
	}

	function visit_timeout(transid){
	    setTimeout(function(){
  			showmodal("confirm", "Are you sure you want to leave?", "confirmvisit_timeout", transid+"|", "", null, "0");
	    }, 500);
	}

	function confirmvisit_timeout(transid){
		$.ajax({
			type: 'POST',
			url: 'visitorlogs/class.php',
			data: 'transid=' + transid + '&form=visit_timeout',
			success:function(data){
				var arr = data.split("|");
			    if(arr[0] == "1"){
			        setTimeout(function(){
			          	showmodal("alert", arr[1], "tblvisitorlog", null, "", null, "0");
			        }, 1000)
			    }else{
			        setTimeout(function(){
			          	showmodal("alert", arr[1], "", null, "", null, "0");
			        }, 1000)
			    }
			}
		})
	}

	function checkfirstdate(){
	  	var eto = $("#chkdateincheck");
	  	if(eto.is(":checked")){
	    	$("#chkdateoutcheck").prop("checked", false);
	    	$("#div_dateout").css("background-color", "#f5f5f0");
	    	$("#div_datein").css("background-color", "white");
	    	$(".div_datein").prop("disabled", false);
	    	$(".div_dateout").prop("disabled", true);
	  	}else{
	    	$("#chkdateincheck").prop("checked", true);
	  	}
	}

	function checksecdate(){
		var eto = $("#chkdateoutcheck");
		if(eto.is(":checked")){
		    $("#chkdateincheck").prop("checked", false);
		    $("#div_datein").css("background-color", "#f5f5f0");
		    $("#div_dateout").css("background-color", "white");
		    $(".div_dateout").prop("disabled", false);
		    $(".div_datein").prop("disabled", true);
		}else{
		    $("#chkdateoutcheck").prop("checked", true);
		}
	}

	function checkfirstdate2(){
	  	var eto = $("#chkdateincheck2");
	  	if(eto.is(":checked")){
	    	$("#chkdateoutcheck2").prop("checked", false);
	    	$("#div_dateout2").css("background-color", "#f5f5f0");
	    	$("#div_datein2").css("background-color", "white");
	    	$(".div_datein2").prop("disabled", false);
	    	$(".div_dateout2").prop("disabled", true);
	  	}else{
	    	$("#chkdateincheck2").prop("checked", true);
	  	}
	}

	function checksecdate2(){
		var eto = $("#chkdateoutcheck2");
		if(eto.is(":checked")){
		    $("#chkdateincheck2").prop("checked", false);
		    $("#div_datein2").css("background-color", "#f5f5f0");
		    $("#div_dateout2").css("background-color", "white");
		    $(".div_dateout2").prop("disabled", false);
		    $(".div_datein2").prop("disabled", true);
		}else{
		    $("#chkdateoutcheck2").prop("checked", true);
		}
	}

	function saveVisitorLogsFilter(){
	  	var Date1 = $("#txtVisitDateInFrom").val();
	  	var Date2 = $("#txtVisitDateInTo").val();
	  	var Date3 = $("#txtVisitDateOutFrom").val();
	  	var Date4 = $("#txtVisitDateOutTo").val();
	    var module = "VisitorLogs";
	    var checked = "";
	    $('input:checkbox[name="form-field-checkboxfltrby"]').each(function(){
	        if($(this).is(":checked")){
	            var value = $(this).attr("value");
	            checked += value + "|";
	        }
	    })
	    var checked2 = "";
	    $('input:checkbox[name="form-field-checkboxfltrby"]').each(function(){
	        var value2 = $(this).attr("value");
	        checked2 += value2 + "|";
	    })  
	    if($("#chkdateincheck").is(":checked")){ var xcheck = "filterdatebydatein"; }
	    if($("#chkdateoutcheck").is(":checked")){ var xcheck = "filterdatebydateout"; }  
	    $.ajax({
	        type: 'POST',
	        url: 'filter/class.php',
	        data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&Date3=' + Date3 + '&Date4=' + Date4 + '&xcheck=' + xcheck + '&form=saveFilters', 
	        success: function(data){
		      	tblvisitorlog();
	            $("#LINK_VisitorLogs_filter").click();
	        }
	    })
	}

	function loadVisitorLogsFilter(module){
		$.ajax({
		    type: 'POST',
		    url: 'filter/class.php',
		    data: 'module=' + module + '&form=loadFilters',
		    success: function(data){
		      	var arr = data.split("#");
		      	var arr2 = arr[0].split("|");
		      	for(var i=0; i<=arr2.length-2; i++){
		      	    $('input:checkbox[id="filter_'+arr2[i]+'"][value="'+arr2[i]+'"]').attr('checked', 'checked');
		      	}
		      	var arr3 = arr[1].split("|");
		      	$("#txtVisitDateInFrom").val(arr3[0]);
		      	$("#txtVisitDateInTo").val(arr3[1]);
		      	$("#txtVisitDateOutFrom").val(arr3[2]);
		      	$("#txtVisitDateOutTo").val(arr3[3]);
		      	if(arr[3] == "filterdatebydatein"){
		        	$("#chkdateincheck").prop("checked", true);
		        	checkfirstdate();
		      	}else{
		        	$("#chkdateoutcheck").prop("checked", true);
		        	checksecdate();
		      	}
		    }
		})
	}

	function printbyfilter(){
	  	$.ajax({
	    	type: 'POST',
	    	url: 'mainclass.php',
	    	data: 'form=getheaderprint',
	    	success:function(data){
	    	  	$("#template").html(data);
	    	  	$("#chkdateincheck2").click();
	    	}
	  	})
	}

	function printmesenpai(){
	  	var stat = "";
	  	$(".chkfilterbystat").each(function(){
	  	  	if($(this).is(":checked")){
	  	    	var value = $(this).attr("value");
	  	    	stat += value + "|";
	  	  	}
	  	})
	  	if($("#chkdateincheck2").is(":checked")){ 
	  	  	var dateFrom = $("#txtVisitDateInFrom2").val();
	  	  	var dateTo = $("#txtVisitDateInTo2").val();
	  	  	var datetype = "DateIn";
	  	}
	  	if($("#chkdateoutcheck2").is(":checked")){ 
	  	  	var dateFrom = $("#txtVisitDateOutFrom2").val();
	  	  	var dateTo = $("#txtVisitDateOutTo2").val();
	  	  	var datetype = "DateOut";
	  	}
	  	$.ajax({
	  	  	type: 'POST',
	  	  	url: 'visitorlogs/class.php',
	  	  	data: 'stat=' + stat + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&datetype=' + datetype + '&form=printmesenpai',
	  	  	success:function(data){
	  	  	  	var arr = data.split("|");
	  	  	  	$("#tblVisitorLogsPrint").html(arr[0]);
	  	  	  	$("#txtVisitorLogsPrintDateFrom").text(arr[1]);
	  	  	  	$("#txtVisitorLogsPrintDateTo").text(arr[2]);
	  	  	    	var toprint = $("#txtVisitorLogsPrint").html();
	  	  	    	var myheight = $(window).height()-40;
	  	  	    	var mywidth = $(window).width()-40;
	  	  	    	var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
	  	  	    	popupWin.document.open();
	  	  	    	popupWin.document.write("<html><head><title></title></head><body 			onload='window.print();'>" + toprint + "</body></html>");
	  	  	    	popupWin.document.close();
	  	  	}
	  	})
	}
</script>