<script type="text/javascript">
	$(function(){
		$(".fixTable").tableHeadFixer(); 
		$("#txtComplaintsPageCount").val("1");
		$("#txt_userpagehr").val("1");
		LoadtblComplaints();
		tblviolation();
		$('[data-rel=tooltip]').tooltip();
		$('[data-rel=popover]').popover({html:true});
		$(".date-picker").datepicker({
			autoHide: true,
			format: 'mm/dd/yyyy',
			todayHighlight: true
		});
		$("#txtSearchComplaints").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtComplaintsPageCount").val("1");
				LoadtblComplaints(); 
			}else if(x == '8'){
				if($('#txtSearchComplaints').val() == ""){
					$("#txtComplaintsPageCount").val("1");
					LoadtblComplaints();
				}
			}
		});
		$("#txtsearchhr").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				tblviolation(); 
			}else if(x == '8'){
				if($('#txtsearchhr').val() == ""){
					tblviolation();
				}
			}
		});
		$("#txtSearchViolator").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				fncIRLoadViolators();
				autoascdesctenantlist(); 
			}else if(x == '8'){
				if($('#txtSearchViolator').val() == ""){
					fncIRLoadViolators();
					autoascdesctenantlist();
				}
			}
		});
		allownumbers();
		radioOption();
		
		$(function(){
			$('.btnsortdash-complaintslist').click(function(){
				if($(this).hasClass("fa-sort-up")){
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#ComplaintsListSortType").val("ASC");
					$("#ComplaintsListSortBy").val(this.id);
					LoadtblComplaints();
				}
				else if($(this).hasClass("fa-sort-down")){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#ComplaintsListSortType").val("DESC");
					$("#ComplaintsListSortBy").val(this.id);
					LoadtblComplaints();
				}else if($(this).hasClass("fa-sort")){
					if($("#ComplaintsListSortType").val() == "ASC"){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#ComplaintsListSortType").val("DESC");
						$("#ComplaintsListSortBy").val(this.id);
						LoadtblComplaints();
					}else{
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#ComplaintsListSortType").val("ASC");
						$("#ComplaintsListSortBy").val(this.id);
						LoadtblComplaints();
					}
				}
			});
		});

		$(function(){
			$('.btnsortdash-violations').click(function(){
				if($(this).hasClass("fa-sort-up")){
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#ViolationsSortType").val("ASC");
					$("#ViolationsSortBy").val(this.id);
					tblviolation();
				}
				else if($(this).hasClass("fa-sort-down")){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#ViolationsSortType").val("DESC");
					$("#ViolationsSortBy").val(this.id);
					tblviolation();
				}else if($(this).hasClass("fa-sort")){
					if($("#ViolationsSortType").val() == "ASC"){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#ViolationsSortType").val("DESC");
						$("#ViolationsSortBy").val(this.id);
						tblviolation();
					}else{
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#ViolationsSortType").val("ASC");
						$("#ViolationsSortBy").val(this.id);
						tblviolation();
					}
				}
			});
		});
	})

	function allownumbers() {
		$(".numberslang").each(function(){
			$(this).keypress(function(event) {
				if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57 || event.which == 44 )) {
					event.preventDefault();
				}
			}); 
		})
	}

	function LoadtblComplaints() {
		var ComplaintsListSortBy = $('#ComplaintsListSortBy').val();
		var ComplaintsListSortType = $('#ComplaintsListSortType').val();
		var page = $("#txtComplaintsPageCount").val();
		var key = $("#txtSearchComplaints").val();
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'page=' + page + '&key=' + key + '&ComplaintsListSortBy=' + ComplaintsListSortBy + '&ComplaintsListSortType=' + ComplaintsListSortType + '&form=LoadtblComplaints',
			beforeSend : function() {
				$('#indexloadingscreen').addClass('myspinner');
			},
			success: function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				if(data != ""){
					$("#tblcomplaints").html(data);
				}else{
					$("#tblcomplaints").html("<tr><td colspan='10' style='text-align: center;'>No Data Found...</td></tr>");
				}
				$("#mdl_NewTPComplaints").modal("hide");
				LoadComplaintsEntries();
				LoadPageComplaints();
			}
		})
	}

	function LoadComplaintsEntries(){
		var page = $("#txtComplaintsPageCount").val();
		var key = $("#txtSearchComplaints").val();
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'key=' + key + '&page=' + page + '&form=LoadComplaintsEntries',
			success: function(data){
				$("#txtComplaintsEntries").text(data);
			}
		});
	}

	function LoadPageComplaints(){
		var page = $("#txtComplaintsPageCount").val();
		var key = $("#txtSearchComplaints").val();
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'key=' + key + '&page=' + page + '&form=LoadPageComplaints',
			success: function(data){
				$("#ulPageComplaints").html(data);
			}
		});
	}

	function pagination(page, pagenums){
		$(".pgnumpcomplaints").removeClass("active");
		$("#pgcomplaints" + pagenums).addClass("active");
		$("#txtComplaintsPageCount").val(page);
		LoadtblComplaints();
	}

	function printcomplaints(){
		var dateFrom = $("#dateFrom").val();
		var dateTo = $("#dateTo").val();
		var mallid = $("#printbymec").val();
		if(mallid != ""){
			$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&mallid=' + mallid + '&form=printcomplaints',
			success:function(data){
				var arr = data.split("|");
				$("#contentngcomplaints").html(arr[0]);
				$("#dateFrom2").text(arr[1]);
				$("#dateTo2").text(arr[2]);
					$.ajax({
						type: 'POST',
						url: 'mainclass.php',
						data: 'mallID=' + mallid + '&form=getheaderprint',
						success:function(data){
							$("#template").html(data);
							var toprint = $("#div_form_complaints").html();
							var myheight = $(window).height()-40;
							var mywidth = $(window).width()-40;
							var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
							popupWin.document.open();
							popupWin.document.write("<html><head><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
							popupWin.document.close();
						}
					})
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please select mall.", "", null, "", null, "0");
			}, 500)
		}
	}

	function loadComplaintsFilter(module){
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
				$("#dateentrystart").val(arr2[0]);
				$("#dateentryend").val(arr2[1]);
				for(var i=0; i<=arr3.length-1; i++){
					$('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
				}
				for(var i=0; i<=arr4.length-1; i++){
					$('input:checkbox[id="filter_'+arr4[i]+'"][value="'+arr4[i]+'"]').attr('checked', 'checked');
				}
			}
		})
	}

	function saveComplaintsFilter(){
		var module = "Complaints";
		var checked = "";
		$('input:checkbox[name="form-field-checkbox"]').each(function(){
			if($(this).is(":checked")){
				var value = $(this).attr("value");
				checked += value + "|";
			}
		})

		var checked2 = "";
		$('input:checkbox[name="form-field-checkbox"]').each(function(){
				var value2 = $(this).attr("value");
				checked2 += value2 + "|";
		})

		var checked3 = "";
		$('input:checkbox[name="form-field-checkbox-pstat"]').each(function(){
			if($(this).is(":checked")){
				var value3 = $(this).attr("value");
				checked3 += value3 + "|";
			}
		})        

		var xcheck = "";
		$('input:checkbox[name="form-field-checkbox-angbawatisaaymaykarapatangmamili"]').each(function(){
			if($(this).is(":checked")){
				var value4 = $(this).attr("value");
				xcheck += value4 + "|";
			}
		})    

		var Date1 = $("#dateentrystart").val();
		var Date2 = $("#dateentryend").val();

		$.ajax({
			type: 'POST',
			url: 'filter/class.php',
			data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&xcheck=' + xcheck + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
			success: function(data){
				LoadtblComplaints();
				$("#LINK_Complaints_filter").click();
			}
		})
	}

	function printcomplaint(csn, mallid){
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'csn=' + csn + '&form=printcomplaint',
			success:function(data){
				var arr = data.split("|");
				$("#printcomplainttradename").text(arr[0]);
				$("#printcomplaintmallname").text(arr[1]);
				$("#printcomplaintwingname").text(arr[2]);
				$("#printcomplaintfloorname").text(arr[3]);
				$("#printcomplaintunitname").text(arr[4]);
				$("#printcomplaintcomplaintdate").text(arr[5]);
				$("#printcomplaintusername").text(arr[6]);
				$("#printcomplaintcomplaintcode").text(arr[7]);
				$("#printcomplaintdescription").text(arr[8]);
				$("#printcomplaintassignedperson").text(arr[9]);
				$("#printcomplainttenantid").text(arr[10]);
				$.ajax({
					type: 'POST',
					url: 'mainclass.php',
					data: 'mallID=' + mallid + '&form=getheaderprint',
					success: function(data){
						$("#template2").html(data);
					}, complete: function(){
						var toprint = $("#printcomplaint").html();
						var myheight = $(window).height()-40;
						var mywidth = $(window).width()-40;
						var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
						popupWin.document.open();
						popupWin.document.write("<html><head><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
						popupWin.document.close();
					}
				})
			}
		})
	}

	function NewTPComplaints(){
		$("#mdl_NewTPComplaintCode").modal("hide");
		$.ajax({
			type: 'POST',
			url: 'tenants/tenantmainclass.php',
			data: 'form=loadComplaintCodes',
			success:function(data){
				$("#txtTPComplaints").html(data);
				$("#txtTPComplaints").val("");
				$("#txtTPDescription").val("");
				$("#txtTPAddComplaints").val("");
				$("#txtTPAddDescription").val("");
			}
		})
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'form=showTenantList',
			success:function(data){
				$("#txtTPTenantID").html(data);
			}   
		})
	}

	function ShowPreDescription(val){
		$.ajax({
			type: 'POST',
			url: 'tenants/tenantmainclass.php',
			data: 'ComplaintCode=' + val + '&form=ShowPreDescription',
			success:function(data){
				$("#txtTPDescription").val(data);
			}
		})
	}

	function AddTPComplaintCode(){
		$("#mdl_NewTPComplaintCode").modal("show");
	}

	function SaveNewComplaintCode(){
		var Code = $("#txtTPAddComplaints").val();
		var Description = $("#txtTPAddDescription").val();
		var PrioStat = "";
		$(".radPrioStat").each(function(){
			if($(this).is(":checked")){
				PrioStat = $(this).val();
			}
		})
		var count = 0;
		$(".ComplaintsReq2").each(function(){
			if($(this).val() == ""){
				$(this).css("border-color","#f2a696");
				count++;
			}else{
				$(this).css("border-color","#D5D5D5");
			}
		})
		if(count == 0){
			if(PrioStat != ""){
				$.ajax({
					type: 'POST',
					url: 'tenants/tenantmainclass.php',
					data: 'Code=' + Code + '&Description=' + Description + '&PrioStat=' + PrioStat + '&form=SaveNewComplaintCode',
					success:function(data){
						var arr = data.split("|");
						if(arr[0] == 1){
							setTimeout(function(){
								showmodal("alert", arr[1], "NewTPComplaints", null, "", null, "0");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", arr[1], "", null, "", null, "1");
							}, 500)
						}
					}
				})
			}else{
				setTimeout(function(){
					showmodal("alert", "Please select priority status.", "", null, "", null, "1");
				}, 500)
			}
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function SavenewTPComplaints(){
		var ComplaintCode = $("#txtTPComplaints").val();
		var ComplaintDesc = $("#txtTPDescription").val();
		var TenantID = $("#txtTPTenantID").val();
		var count = 0;
		$(".ComplaintsReq").each(function(){
			if($(this).val() == "" || $(this).val() == "undefined"){
				$(this).css("border-color","#f2a696");
				count++;
			}else{
				$(this).css("border-color","#D5D5D5");
			}
		})
		if(count == 0){
			$.ajax({
				type: 'POST',
				url: 'tenants/tenantmainclass.php',
				data: 'ComplaintCode=' + ComplaintCode + '&ComplaintDesc=' + ComplaintDesc + '&TenantID=' + TenantID + '&form=SavenewTPComplaints',
				success:function(data){
					var arr = data.split("|");
					if(arr[0] == 1){
						setTimeout(function(){
							showmodal("alert", arr[1], "LoadtblComplaints", null, "", null, "0");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", arr[1], "", null, "", null, "1");
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

	function showlegendsofcomplaints(){
		$("#legendsofcomplaints").css("display", "block");
		$("#legendsofhouserules").css("display", "none");
	}

	function hidelegendsofcomplaints(){
		$("#legendsofcomplaints").css("display", "none");
		$("#legendsofhouserules").css("display", "block");
	}

// <<<<<<<<<<<<<<<<<<<<<<<<<< START OF INCIDENT REPORTS >>>>>>>>>>>>>>>>>>>>>>>>

	function tblviolation(){
		var ViolationsSortBy = $('#ViolationsSortBy').val();
		var ViolationsSortType = $('#ViolationsSortType').val();
		var key = $("#txtsearchhr").val();
		var page = $("#txt_userpagehr").val();
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'page=' + page + '&key=' + key + '&ViolationsSortBy=' + ViolationsSortBy + '&ViolationsSortType=' + ViolationsSortType + '&form=tblviolation',
			beforeSend:function(){
				$('#indexloadingscreen').addClass('myspinner');
			},
			success:function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				if(data != ""){
					$("#tblviolation").html(data);
				}else{
					$("#tblviolation").html("<tr><td colspan='7' style='text-align: center;'>No Data Found...</td></tr>");
				}
				loadentriesofhr();
				loadpagehr();
			}
		})
	}

	function loadentriesofhr(){
		var page = $("#txt_userpagehr").val();
		var key = $("#txtsearchhr").val();
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: '&key=' + key + '&page=' + page + '&form=loadentriesofhr',
			success: function(data){
				$("#txthrentries").text(data);
			}
		});
	}

	function loadpagehr(){
		var page = $("#txt_userpagehr").val();
		var key = $("#txtsearchhr").val();
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: '&key=' + key + '&page=' + page + '&form=loadpagehr',
			success: function(data){
				$("#ulpaginationhr").html(data);
			}
		});
	}

	function createviolation(){
		$("#modalviolation").modal("show");
		$("#chktenant").click();
		fncIRLoadMall();
	}

	function modalviolationselection(){
		$("#modalviolationselection").modal("show");
		tblviolationlist();
	}

	function closeandclearviolationcreationmodal(){
		$("#modalviolation").modal("hide");
		$("#tbodySelVioList").html("");
		$("#tbodyIRVioList").html("");
		tblviolation();
	}

	function tblviolationlist(){
		var ids = "";
		$("#tbodyIRVioList tr").each(function(){
			ids += $(this).attr("id") + "|";
		})
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'ids=' + ids + '&form=tblviolationlist',
			beforeSend : function() {
				$('#indexloadingscreen').addClass('myspinner');
			},
			success: function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				$("#tblviolationlist").html(data);
				$("#tblviolationlist tr").each(function(){
					$(this).click(function(){
						var HRCode = $(this).find(".HRCode").text();
						var HRDesc = $(this).find(".HRDesc").text();
						$("#tbodyIRVioList").append("<tr id=\""+ HRCode +"\">" +
														"<td>"+ HRCode +"</td>" +
														"<td>"+ HRDesc +"</td>" +
														"<td><label id='lblRemark-"+ HRCode +"'></label></td>" +
														"<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#"+ HRCode +"\").remove();' title='Remove violation'><i class='fa fa-trash-o'></i></button></td>" +
													"</tr>");
						$("#"+$(this).attr("id")).remove();
					})
				})  
			}
		})
	}

	function fncIRLoadMall(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success:function(data){
				$("#txtIRSelectMall").html(data);
			}, complete: function(){
				fncIRLoadViolators();
			}
		})
	}

	function fncIRLoadViolators(){
		var TenantListSortBy = $('#TenantListSortBy').val();
		var TenantListSortType = $('#TenantListSortType').val();
		var key = $("#txtSearchViolator").val();
		var mallID = $("#txtIRSelectMall").val();
		var ids = "";
		$("#tbodySelVioList tr").each(function(){
			ids += $(this).attr("id") +"|";
		})
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'ids=' + ids + '&key=' + key + '&mallID=' + mallID + '&TenantListSortBy=' + TenantListSortBy + '&TenantListSortType=' + TenantListSortType + '&form=fncIRLoadViolators',
			success:function(data){
				$("#tbodyIRTenantList").html(data);
				$("#tbodyIRTenantList tr").each(function(){
					$(this).click(function(){
						var TenantID = $(this).find(".IRTenantID").text();
						var TradeName = $(this).find(".IRTenantName").text();
						$("#tbodySelVioList").append("<tr id=\""+ TenantID +"\">" +
														"<td>"+ TradeName +"</td>" +
														"<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#"+ TenantID +"\").remove();' title='Remove violator'><i class='fa fa-trash-o'></i></button></div></td>" +
													"</tr>");
						$("#"+$(this).attr("id")).remove();
					})
				})  
			}
		})
	}

	function autoascdesctenantlist(){
		$('.btnsortdash-tenantlist').click(function(){
			if($(this).hasClass("fa-sort-up")){
				$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
				$("#TenantListSortType").val("ASC");
				$("#TenantListSortBy").val(this.id);
				fncIRLoadViolators();
			}
			else if($(this).hasClass("fa-sort-down")){
				$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
				$("#TenantListSortType").val("DESC");
				$("#TenantListSortBy").val(this.id);
				fncIRLoadViolators();
			}else if($(this).hasClass("fa-sort")){
				if($("#TenantListSortType").val() == "ASC"){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#TenantListSortType").val("DESC");
					$("#TenantListSortBy").val(this.id);
					fncIRLoadViolators();
				}else{
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#TenantListSortType").val("ASC");
					$("#TenantListSortBy").val(this.id);
					fncIRLoadViolators();
				}
			}
		});
	}

	function autoascdescviolationlist(){
		$('.btnsortdash-violationlist').click(function(){
			if($(this).hasClass("fa-sort-up")){
				$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
				$("#ViolationListSortType").val("ASC");
				$("#ViolationListSortBy").val(this.id);
				fncIRLoadViolators();
			}
			else if($(this).hasClass("fa-sort-down")){
				$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
				$("#ViolationListSortType").val("DESC");
				$("#ViolationListSortBy").val(this.id);
				fncIRLoadViolators();
			}else if($(this).hasClass("fa-sort")){
				if($("#TenantListSortType").val() == "ASC"){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#ViolationListSortType").val("DESC");
					$("#ViolationListSortBy").val(this.id);
					fncIRLoadViolators();
				}else{
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#ViolationListSortType").val("ASC");
					$("#ViolationListSortBy").val(this.id);
					fncIRLoadViolators();
				}
			}
		});
	}

	function saveviolationticket(){
		var TenantID = "";
		$("#tbodySelVioList tr").each(function(){
			TenantID += $(this).attr("id") +"|";
		})
		var ViolationList = "";
		$("#tbodyIRVioList tr").each(function(){
			ViolationList += $(this).attr("id") + "|" + $(this).find("td").eq(2).text() + "|" + $(this).find("td").eq(3).text() + "@";
		});
		if(TenantID == ""){
			setTimeout(function(){
				showmodal("alert", "Please select a violator.", "", null, "", null, "1");
			}, 500)
		}else{
			if(ViolationList == ""){
				setTimeout(function(){
					showmodal("alert", "Please select a violation.", "", null, "", null, "1");
				}, 500)
			}else{
				$.ajax({
					type: 'POST',
					url: 'complaints/class.php',
					data: 'TenantID=' + TenantID + '&ViolationList=' + ViolationList + '&form=saveviolationticket',
					beforeSend : function() {
						$('#preMdlViolation').addClass('myspinner');
					},
					success: function(data){
						$('#preMdlViolation').removeClass('myspinner');
						if(data == "1"){
							setTimeout(function(){
								showmodal("alert", "Violation ticket successfully created.", "closeandclearviolationcreationmodal", null, "", null, "0");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", "Failed to record violation.", "", null, "", null, "1");
							}, 500)
						}
					}
				})
			}
		}
	}

	function saveHouseRulesFilter(){
		var module = "HouseRules";
		var checked = "";
		$('input:checkbox[name="form-field-checkbox-hrfilter"]').each(function(){
			if($(this).is(":checked")){
				var value = $(this).attr("value");
				checked += value + "|";
			}
		})
		var checked2 = "";
		$('input:checkbox[name="form-field-checkbox-hrfilter"]').each(function(){
			var value2 = $(this).attr("value");
			checked2 += value2 + "|";
		})
		var checked3 = "";
		$('input:checkbox[name="form-field-checkbox-hrstat"]').each(function(){
			if($(this).is(":checked")){
				var value3 = $(this).attr("value");
				checked3 += value3 + "|";
			}
		})
		var Date1 = $("#hrstart").val();
		var Date2 = $("#hrend").val();
		$.ajax({
			type: 'POST',
			url: 'filter/class.php',
			data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
			success: function(data){
				tblviolation();
				$("#LINK_HouseRules_filter").click();
			}
		})
	}

	function loadHouseRulesFilter(module){
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
				$("#hrstart").val(arr2[0]);
				$("#hrend").val(arr2[1]);
				for(var i=0; i<=arr3.length-1; i++){
					$('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
				}
			}
		})
	}

	function printcomplaintshr(){
		var dateFrom = $("#dateFromhr").val();
		var dateTo = $("#dateTohr").val();
		var mallid = $("#printbymehr").val();
		if(mallid != ""){
			$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&mallid=' + mallid + '&form=printcomplaintshr',
			success:function(data){
				var arr = data.split("|");
				$("#listofviolatorstoprint").html(arr[0]);
				$("#dateFromhrprint").text(arr[1]);
				$("#dateTohrprint").text(arr[2]);
					$.ajax({
						type: 'POST',
						url: 'mainclass.php',
						data: 'mallID=' + mallid + '&form=getheaderprint',
						success:function(data){
							$("#template3").html(data);
							var toPrint = document.getElementById("allhouserulesviolations");
							var myheight = $(window).height()-40;
							var mywidth = $(window).width()-40;
							var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
							popupWin.document.open();
							popupWin.document.write('<html><link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" /><header style="font-size: 16px; font-weight: 700;"></header><br><body onload="window.print();">' );
							popupWin.document.write( toPrint.innerHTML);
							popupWin.document.write('</body></html>');
							popupWin.document.close();
						}
					})
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please select mall.", "", null, "", null, "1");
			}, 500)
		}
	}

	function deletethisticket(vsn){
		setTimeout(function(){
			showmodal("confirm", "Are you sure you want to delete this ticket?", "confirmdeleteticket", vsn+"|", "", null, "0");
		}, 500)
	}

	function confirmdeleteticket(vsn){
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'vsn=' + vsn + '&form=deletethisticket',
			beforeSend : function() {
				$('#indexloadingscreen').addClass('myspinner');
			},
			success: function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "House rules violation ticket successfully deleted.", "tblviolation", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to delete.", "tblviolation", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function viewticket(vsn, status, isPosted){
		$("#viewticketmodal").modal("show");
		if(isPosted == 1){
			$("#btnpostingsabilling").css("display", "none");
		}else{
			if(status == "Resolved"){
				$("#btnpostingsabilling").css("display", "inline-block");
			}else{
				$("#btnpostingsabilling").css("display", "none");
			}
		}
		fncloadViolationList(vsn)
	}

	function printnotificationofviolation(VSN, MallID){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'mallID=' + MallID + '&form=getheaderprint',
			success: function(data){
				$("#template4").html(data);
			},
			complete: function(){
				$.ajax({
					type: 'POST',
					url: 'complaints/class.php',
					data: 'vsn=' + VSN + '&form=fncPrintIncidentReport',
					success:function(data){
						var arr = data.split("|");
						$("#tbodyPrintNoV").html(arr[0]);
						$("#modaltxttamount").text(arr[1]);
						$("#txtPrintViolator").text(arr[2]);
						$("#txtPrintVSN").text(VSN);
						$("#lblIRUnitNo").text(arr[3]);
						$("#lblIRDate").text(arr[4]);
						$("#lblIRTime").text(arr[5]);
					}, complete: function(){
						var toPrint = document.getElementById("notificationofviolation");
								var myheight = $(window).height();
								var mywidth = $(window).width();
								var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
								popupWin.document.open();
								popupWin.document.write('<html><link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" /><header style="font-size: 16px; font-weight: 700;"></header><br><body onload="window.print();">' );
								popupWin.document.write( toPrint.innerHTML);
								popupWin.document.write('</body></html>');
								popupWin.document.close();
					}
				})
				// $.ajax({
				//     type: 'POST',
				//     url: 'complaints/class.php',
				//     data: 'violatorid=' + violatorid + '&type=' + type + '&form=viewticket',
				//     success:function(data){
				//         $("#txtunitnumbernanagiiba").text(data);
				//         $("#txtvsn").text(vsn);
				//         $("#txttn").text(violatorname);
				//         $("#txtd").text(date);
				//         $("#txtt").text(time);
				//     },
				//     complete: function(){
				//         $.ajax({
				//             type: 'POST',
				//             url: 'complaints/class.php',
				//             data: 'vsn=' + vsn + '&form=viewtickettable2',
				//             success:function(data2){
				//                 var arr = data2.split("|");
				//                 $("#tblnotificationofviolation").html(data2);
				//             },
				//             complete: function(){
								
				//             }
				//         })
				//     }
				// })
			}
		})
	}

	function fncAddResponse(code, vsn, status, resolution, ResponseCode){
		$("#modalAddReso").modal("show");
		$("#modaltxtReso").val(resolution);
		$("#txtIRAttachVSNRes").val(vsn)
		$("#txtIRAttachHRCodeRes").val(code)
		$("#txtIRRespoCode").val(ResponseCode);
		$(".rdViolationStatus").each(function(){
			if($(this).val() == status){
				$(this).prop("checked", true);
			}
		})
		$("#txtIRAttachCountRes").val("1");
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'ResponseCode=' + ResponseCode + '&form=fncRespoAttachment',
			success: function(data){
				if(data == ""){
					$("#divIRAttachmentResp").html( "<div class='col-md-4'>" +
													"Attachment" +
												"</div>" +
												"<div class='col-md-8'>" +
													"<input type='file' class='txtIRImages btnResponse' name='txtIRImages1'>" +
												"</div>");
				}else{
					$("#divIRAttachmentResp").html(data+"<div class='col-md-4' style='margin-top: 10px;'></div>" +
													"<div class='col-md-8' style='margin-top: 10px;'>" +
														"<input type='file' class='txtIRImages btnResponse' name='txtIRImages1'>" +
													"</div>");
				}
			}, complete: function(){
				$('.txtIRImages').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false
				});
				if(Status == "Resolved"){
					$(".btnResponse").prop("disabled", true);
					$("#modaltxtReso").attr("readonly", "readonly");
				}else{
					$(".btnResponse").prop("disabled", false);
					$("#modaltxtReso").removeAttr("readonly");
				}
			}
		})
	}

	function fncAppendAttachmentDIVResp(){
		var count = $("#txtIRAttachCountRes").val();
		count = Number(count) + 1;
		$("#divIRAttachmentResp").append(   "<div class='col-md-4'></div>" +
										"<div class='col-md-8'>" +
											"<input type='file' class='txtIRImages' name='txtIRImages"+ count +"'>" +
										"</div>");
		$('.txtIRImages').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});
		$("#txtIRAttachCountRes").val(count);
	}

	function savemodalAddReso(){
		var data = new FormData($('#frmIRRespoAttachments')[0]);
		$.ajax({
			type: 'POST',
			url: 'complaints/uploadRespoAttach.php',
			data: data,
			mimeType: 'multipart/form-data',
			contentType: false,
			cache: false,
			processData: false,
			success:function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Response successfully saved.", "closemodalAddReso", null, "", null, "0");
					}, 500)
				}else if(data == 3){
					setTimeout(function(){
						showmodal("alert", "Response successfully updated.", "closemodalAddReso", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to save response.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function closemodalAddReso(){
		var vsn = $("#txtIRAttachVSNRes").val();
		fncloadViolationList(vsn)
		$("#modalAddReso").modal("hide");
	}

	function checkmunabagopost(){
		setTimeout(function(){
			showmodal("confirm", "Are you sure you want to post all charges to billing?", "fncPostBillingIR", null, "", null, "1");
		}, 500)
	}

	function fncPostBillingIR(){
		var vsn = $("#lblIRVSN").text();
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'vsn=' + vsn + '&form=checkmunabagopost',
			beforeSend : function() {
				$('#indexloadingscreen').addClass('myspinner');
			},
			success: function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				if(data == "Resolved"){
					$.ajax({
						type: 'POST',
						url: 'complaints/class.php',
						data: 'vsn=' + vsn + '&form=postmonabes',
						success:function(data2){
							if(data2 == "1"){
								setTimeout(function(){
									showmodal("alert", "Charges are now posted to billing.", "tblviolation", null, "", null, "0");
								}, 500)
								$("#viewticketmodal").modal("hide");
							}else{
								setTimeout(function(){
									showmodal("alert", "Posting Failed.", "", null, "", null, "1");
								}, 500)
							}
						}
					})
				}else{
					setTimeout(function(){
						showmodal("alert", "Some violation are not yet resolved posting failed.", "tblviolation", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function showprintbyme(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success:function(data){
				$(".malloption").html(data);
			}
		})
	}

	function fncAddRemarks(HRCode, VSN, Status, Remarks, RemarksCode){
		$("#mdlAddRemarks").modal("show");
		$("#txtIRRemarksCode").val(RemarksCode);
		$("#txtIRRemarks").val(Remarks);
		$("#txtIRAttachVSN").val(VSN);
		$("#txtIRAttachHRCode").val(HRCode);
		$("#txtIRAttachCount").val("1");
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'RemarksCode=' + RemarksCode + '&form=fncRemarksAttachment',
			success: function(data){
				if(data == ""){
					$("#divIRAttachment").html( "<div class='col-md-4'>" +
													"Attachment" +
												"</div>" +
												"<div class='col-md-8'>" +
													"<input type='file' class='txtIRImages btnRemarks' name='txtIRImages1'>" +
												"</div>");
				}else{
					$("#divIRAttachment").html(data+"<div class='col-md-4' style='margin-top: 10px;'></div>" +
													"<div class='col-md-8' style='margin-top: 10px;'>" +
														"<input type='file' class='txtIRImages btnRemarks' name='txtIRImages1'>" +
													"</div>");
				}
			}, complete: function(){
				$('.txtIRImages').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false
				});
				if(Status == "Resolved"){
					$(".btnRemarks").prop("disabled", true);
					$("#txtIRRemarks").attr("readonly", "readonly");
				}else{
					$(".btnRemarks").prop("disabled", false);
					$("#txtIRRemarks").removeAttr("readonly");
				}
			}
		})
	}

	function fncAppendAttachmentDIV(){
		var count = $("#txtIRAttachCount").val();
		count = Number(count) + 1;
		$("#divIRAttachment").append(   "<div class='col-md-4'></div>" +
										"<div class='col-md-8'>" +
											"<input type='file' class='txtIRImages' name='txtIRImages"+ count +"'>" +
										"</div>");
		$('.txtIRImages').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});
		$("#txtIRAttachCount").val(count);
	}

	function fncSaveIRRemarks(){
		var VSN = $("#txtIRAttachVSN").val();
		var data = new FormData($('#frmIRRemarksAttachments')[0]);
		$.ajax({
			type: 'POST',
			url: 'complaints/uploadRemarksAttach.php',
			data: data,
			mimeType: 'multipart/form-data',
			contentType: false,
			cache: false,
			processData: false,
			success:function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Remarks successfully saved.", "closemodalAddRemarks", VSN+"|", "", null, "0");
					}, 500)
				}else if(data == 3){
					setTimeout(function(){
						showmodal("alert", "Remarks successfully updated.", "closemodalAddRemarks", VSN+"|", "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to save remarks.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function closemodalAddRemarks(vsn){
		$("#txtIRRemarks").val("");
		$("#mdlAddRemarks").modal("hide");
		fncloadViolationList(vsn);
	}

	function fncModifyViolation(VSN, HRCode, xStatus, xfine){
		$("#txtModVSN").val(VSN);
		$("#txtModVCode").val(HRCode);
		$("#mdlModifyViolation").modal("show");
		$("#txtchargeamount").val(xfine);
		$(".rdViolationStatus").each(function(){
			if($(this).val() == xStatus){
				$(this).prop("checked", true);
			}
		})

		if ( xfine < 1 ) {
			$("#s2bill").attr("disabled", "disabled");
			$("#snorm").removeAttr("disabled");
		} else {
			$("#snorm").attr("disabled", "disabled");
			$("#s2bill").removeAttr("disabled");
		}
	}

	function fncSaveModifiedViolation(){
		var VSN = $("#txtModVSN").val();
		var HRCode = $("#txtModVCode").val();
		var xFine = $("#txtchargeamount").val();
		var Status = "";
		$(".rdViolationStatus").each(function(){
			if($(this).is(":checked")){
				Status = $(this).val(); 
			}
		})
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'VSN=' + VSN + '&HRCode=' + HRCode + '&xFine=' + xFine + '&Status=' + Status + '&form=fncSaveModifiedViolation',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						$("#mdlModifyViolation").modal("hide");
						showmodal("alert", "Violation modification successfull.", "fncloadViolationList", VSN+"|", "", null, "0");
					}, 500)
				}else{  
					setTimeout(function(){
						showmodal("alert", "Failed to save changes.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function fncloadViolationList(VSN){
		$.ajax({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'vsn=' + VSN + '&form=fncloadViolationList',
			success:function(data){
				var arr = data.split("|");
				$("#tblticketinformation").html(arr[0]);
				$("#modaltxttamount").text(arr[1]);
				$("#lblIRTenantName").text(arr[2]);
				$("#lblIRVSN").text(VSN);
				$("#lblIRUnitNo").text(arr[3]);
				$("#lblIRDate").text(arr[4]);
				$("#lblIRTime").text(arr[5]);
			}
		})
	}

	function radioOption() {
		$(".rdViolationStatus").each(function(){
			var eto = $(this);

			eto.click(function(){
				if ( eto.val() == 'Pending' ) {
					$("#s2bill").attr("disabled", "disabled");
					$("#snorm").removeAttr("disabled");
				} else {
					if ( $("#txtchargeamount").val() != 0.00 ) {
						$("#s2bill").removeAttr("disabled");
						$("#snorm").attr("disabled", "disabled");
					}
				}
			})
		})

		$("#txtchargeamount").blur(function(){
			var eto2 = $(this);

			if ( eto2.val() == 0 ) {
				$("#s2bill").attr("disabled", "disabled");
				$("#snorm").removeAttr("disabled");
				$("#radResolve").attr("checked", "checked");
				// $(".rdViolationStatus").attr("disabled", "disabled");
			} else {
				var istat = $('input[name=form-field-radio-stat]:checked').val();

				if ( istat == "Resolved" ) {
					$("#s2bill").removeAttr("disabled");
					$("#snorm").attr("disabled", "disabled");
				} else {
					$("#s2bill").attr("disabled", "disabled");
					$("#snorm").removeAttr("disabled");
				}
					
				// $("#radPending").attr("checked", "checked");
				// $(".rdViolationStatus").removeAttr("disabled");
			}
		})
	}

	function deleteViolationz(id, vCode) {
		showmodal("confirm", "Are you sure you want to delete this violation?", "deleteViolation2", id+"|"+vCode, "", null, "1");
		// alert(id);
		// alert(vCode);
	}

	function deleteViolation2(id, vCode) {
		// alert(id);
		// alert(vCode);
		$.ajax ({
			type: 'POST',
			url: 'complaints/class.php',
			data: 'id=' + id + '&vCode=' + vCode + '&form=deleteViolation',
			success:function(data){
				if ( data == 1 ) {
					setTimeout(function(){
						showmodal("alert", "Violation successfully deleted.", "", null, "", null, "0");
						fncloadViolationList(id);
					}, 800)
				} else {
					setTimeout(function(){
						showmodal("alert", "Failed to delete violation.", "", null, "", null, "1");
					})
				}
			}
		})
	}
</script>