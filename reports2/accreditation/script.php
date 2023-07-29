<script type="text/javascript">
	$(function(){
		$(".fixTable").tableHeadFixer(); 
		$(".date-picker").datepicker({
			autoHide: true,
			format: 'mm/dd/yyyy',
			todayHighlight: true
		});
		$("#txtAccreditationPaymentTypeID").on('keypress', function (event) {
		var regex = new RegExp("^[a-zA-Z!@#$%^*() 0-9\s]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
			if (!regex.test(key)) {
				event.preventDefault();
				return false;
			}
		});
		$("#txtAccreditationPaymentTypeDesc").on('keypress', function (event) {
			var regex = new RegExp("^[a-zA-Z!@#$%^*()0-9\s]+$");
			var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
				if (!regex.test(key)) {
					event.preventDefault();
					return false;
				}
		});
		$(".radServiceCharge").each(function(){
			$(this).click(function(){
				if($(this).attr("id") == "ServiceChargeYes"){
					$("#ServiceChargeVal").removeAttr("readonly");
					$("#ServiceChargeVal").addClass("AccredReq");
				}else{
					$("#ServiceChargeVal").attr("readonly", "readonly");
					$("#ServiceChargeVal").removeClass("AccredReq");
				}
			})
		})
		$(".radLocalTax").each(function(){
			$(this).click(function(){
				if($(this).attr("id") == "LocalTaxYes"){
					$("#LocalTaxVal").removeAttr("readonly");
					$("#LocalTaxVal").addClass("AccredReq");
				}else{
					$("#LocalTaxVal").attr("readonly", "readonly");
					$("#LocalTaxVal").removeClass("AccredReq");
				}
			})
		})
		$("#txtsearchAccreditation").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txt_userpageAccreditation").val("1");
				tblAccreditation(); 
			}else if(x == '8'){
				if($('#txtsearchAccreditation').val() == ""){
					$("#txt_userpageAccreditation").val("1");
					tblAccreditation();
				}
			}
		});
		$("#txt_userpageAccreditation").val("1");
		tblAccreditation();
	})

	function tblAccreditation(){
		var page = $("#txt_userpageAccreditation").val();
		var key = $("#txtsearchAccreditation").val();
		$.ajax({
			type: 'POsT',
			url: 'reports/accreditation/class.php',
			data: 'page=' + page + '&key=' + key + '&form=tblAccreditation',
			beforeSend : function() {
				$('#indexloadingscreen').addClass('myspinner');
			},
			success: function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				if(data.trim() == ""){
					$("#tblAccreditationList").html("<tr><td colspan='7' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblAccreditationList").html(data);
				}
				tblAccreditationEntries();
				tblAccreditationPagination();
			}
		})
	}

	function tblAccreditationEntries(){
		var page = $("#txt_userpageAccreditation").val();
		var key = $("#txtsearchAccreditation").val();
		$.ajax({
			type: 'POST',
			url: 'reports/accreditation/class.php',
			data: 'key=' + key + '&page=' + page + '&form=tblAccreditationEntries',
			success: function(data){
				$("#txtAccreditationEntries").text(data);
			}
		});
	}

	function tblAccreditationPagination(){
		var page = $("#txt_userpageAccreditation").val();
		var key = $("#txtsearchAccreditation").val();
		$.ajax({
			type: 'POST',
			url: 'reports/accreditation/class.php',
			data: 'key=' + key + '&page=' + page + '&form=tblAccreditationPagination',
			success: function(data){
				$("#ulPaginationAccreditation").html(data);
			}
		});
	}

	function tblAccreditationFunc(page, pagenums){
		$(".pgnumpaccreditation").removeClass("active");
		$("#pgaccreditation" + pagenums).addClass("active");
		$("#txt_userpageAccreditation").val(page);
		tblAccreditation();
	}

	function saveAccreditationFilter(){
		var module = "Accreditation";
		var checked = "";
		$('input:checkbox[name="form-field-srchbyaccred"]').each(function(){
			if($(this).is(":checked")){
				var value = $(this).attr("value");
				checked += value + "|";
			}
		})
		var checked2 = "";
		$('input:checkbox[name="form-field-srchbyaccred"]').each(function(){
			var value2 = $(this).attr("value");
			checked2 += value2 + "|";
		}) 
		var checked3 = "";
		$('input:checkbox[name="form-field-accredstat"]').each(function(){
			if($(this).is(":checked")){
				var value3 = $(this).attr("value");
				checked3 += value3 + "|";
			}
		})     
		var Date1 = $("#AccredDateFrom").val();
		var Date2 = $("#AccredDateTo").val();
		$.ajax({
			type: 'POST',
			url: 'filter/class.php',
			data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
			success: function(data){
				$("#LINK_Accreditation_filter").click();
				tblAccreditation();
			}
		})
	}

	function loadAccreditationFilter(module){
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
				$("#AccredDateFrom").val(arr3[0]);
				$("#AccredDateTo").val(arr3[1]);
				arr4 = arr[2].split("|");
				for(var i=0; i<=arr4.length-1; i++){
					$('input:checkbox[id="filter_'+arr4[i]+'"][value="'+arr4[i]+'"]').attr('checked', 'checked');
				}               
			}
		})
	}
	
	function CreateNewAccredSched(){
		$("#CreateNewAccredSched").modal("show");
		$(".clicktoshowall").each(function(){
			var id = this.id;
			if($("#"+id+" i").hasClass("fa fa-chevron-up")){
				$("#"+id).click();
			}
		})
		$(".frmEditOnly").css("display", "none");
		$("#ServiceChargeNo").click();
		$("#LocalTaxNo").click();
		$("#AccredDocCount").val("1");
		$.ajax({
			type: 'POST',
			url: 'reports/accreditation/class.php',
			data: 'form=ShowTenantList',
			success:function(data){
				$("#txtAccredTenant").html(data);
			}
		})
		$("#txtMachineNumber").html("<div class='input-group'>"+
										"<input type='text' class='form-control AccredReq' placeholder='Machine Number'>"+
										"<span class='input-group-btn'>"+
											"<button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\"txtMachineNumber\", \"Wala\")'>"+
												"<span class='ace-icon fa fa-plus icon-on-right bigger-110'></span>"+
											"</button>"+
										"</span>"+
									"</div>");
		$("#txtTelephoneNumber").html("<div class='input-group'>"+
										"<input type='text' class='form-control AccredReq TelephoneNumber' placeholder='(99)-999-9999'>"+
										"<span class='input-group-btn'>"+
											"<button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\"txtTelephoneNumber\", \"TelephoneNumber\")'>"+
												"<span class='ace-icon fa fa-plus icon-on-right bigger-110'></span>"+
											"</button>"+
										"</span>"+
									"</div>");
		$("#txtMobileNumber").html("<div class='input-group'>"+
										"<input type='text' class='form-control AccredReq MobileNumber' placeholder='(999)-999-9999'>"+
										"<span class='input-group-btn'>"+
											"<button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\"txtMobileNumber\", \"MobileNumber\")'>"+
												"<span class='ace-icon fa fa-plus icon-on-right bigger-110'></span>"+
											"</button>"+
										"</span>"+
									"</div>");
		$("#txtAuthorizedRep").html("<div class='input-group'>"+
										"<input type='text' class='form-control AccredReq' placeholder='Name of Representative'>"+
										"<span class='input-group-btn'>"+
											"<button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\"txtAuthorizedRep\", \"Wala\")'>"+
												"<span class='ace-icon fa fa-plus icon-on-right bigger-110'></span>"+
											"</button>"+
										"</span>"+
									"</div>");
		$("#txtAccreditorsRep").html("<div class='input-group'>"+
										"<input type='text' class='form-control AccredReq' placeholder='Name of Representative'>"+
										"<span class='input-group-btn'>"+
											"<button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\"txtAccreditorsRep\", \"Wala\")'>"+
												"<span class='ace-icon fa fa-plus icon-on-right bigger-110'></span>"+
											"</button>"+
										"</span>"+
									"</div>");
		$("#txtDocument").html("<div class='row form-group'>"+
									"<div class='col-md-7'>"+
										"<input type='text' class='form-control' name='AccredDocName1' placeholder='Document Name'>"+
									"</div>"+
									"<div class='col-md-5'>"+
										"<input type='file' class='txtAccredDoc' name='AccredDoc1'>"+
									"</div>"+
								"</div>");
		$('.MobileNumber').mask('(999) 999-9999');
		$('.TelephoneNumber').mask('(99)-999-9999');
		$('.txtAccredDoc').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});
		$(".numonly").keydown(function(event) {
			if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188) {
			}else{
				if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
				   event.preventDefault(); 
				}   
			}
		});
	}

	function div_AddNewField(id, trap){
		var divappend = "";
		var placeholder = "";
		var i = 0;
		$("#"+id+" input").each(function(){
			if(id == "txtMachineNumber"){
				placeholder = "Machine Number";
			}else if(id == "txtTelephoneNumber"){
				placeholder = "(99)-999-9999";
			}else if(id == "txtAuthorizedRep"){
				placeholder = "Name of Representative";
			}else if(id == "txtAccreditorsRep"){
				placeholder = "Name of Representative";
			}else{
				placeholder = "(999)-999-9999";
			}
			var value = $(this).val();
			if(!value.match(/^\s*$/)){
				if (!value.match(/^\s*$/)) {
					divappend += "<input type='text'class='form-control "+trap+" AccredReq' value='"+value+"' style='margin-bottom:5px;' placeholder='"+ placeholder +"'>";
				}else{
					i++;
				}
			}else{
				$(this).val("");
				i++;
			}
		});
		if(i == 0){
			if(id == "txtMachineNumber"){
				divappend += "<div class='input-group'><input type='text'class='form-control' placeholder='Machine Number'><div class='input-group-btn'><button type='button' class='btn  btn-sm btn-success' onclick='div_AddNewField(\""+id+"\", \"Wala\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}else if(id == "txtTelephoneNumber"){
				divappend += "<div class='input-group'><input type='text'class='form-control "+trap+"' placeholder='(99)-999-9999'><div class='input-group-btn'><button type='button' class='btn  btn-sm btn-success' onclick='div_AddNewField(\""+id+"\", \""+trap+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}else if(id == "txtAuthorizedRep"){
				divappend += "<div class='input-group'><input type='text'class='form-control' placeholder='Name of Representative'><div class='input-group-btn'><button type='button' class='btn  btn-sm btn-success' onclick='div_AddNewField(\""+id+"\", \"Wala\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}else if(id == "txtAccreditorsRep"){
				divappend += "<div class='input-group'><input type='text'class='form-control' placeholder='Name of Representative'><div class='input-group-btn'><button type='button' class='btn  btn-sm btn-success' onclick='div_AddNewField(\""+id+"\", \"Wala\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}else{
				divappend += "<div class='input-group'><input type='text'class='form-control "+trap+"' placeholder='(999)-999-9999'><div class='input-group-btn'><button type='button' class='btn  btn-sm btn-success' onclick='div_AddNewField(\""+id+"\", \""+trap+"\")'><i class='icon-only  ace-icon ace-icon fa fa-plus bigger-110'></i></button></div></div>";
			}
		}else{
			if(id == "txtMachineNumber"){
				divappend += "<div class='input-group'><input type='text' class='form-control' placeholder='Machine Number'><span class='input-group-btn'><button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\""+id+"\", \"Wala\")'><span class='ace-icon fa fa-plus icon-on-right bigger-110'></span></button></span></div>";
			}else if(id == "txtTelephoneNumber"){
				divappend += "<div class='input-group'><input type='text' class='form-control "+trap+"' placeholder='(99)-999-9999'><span class='input-group-btn'><button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\""+id+"\", \""+trap+"\")'><span class='ace-icon fa fa-plus icon-on-right bigger-110'></span></button></span></div>";
			}else if(id == "txtAuthorizedRep"){
				divappend += "<div class='input-group'><input type='text' class='form-control' placeholder='Name of Representative'><span class='input-group-btn'><button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\""+id+"\", \"Wala\")'><span class='ace-icon fa fa-plus icon-on-right bigger-110'></span></button></span></div>";
			}else if(id == "txtAccreditorsRep"){
				divappend += "<div class='input-group'><input type='text' class='form-control' placeholder='Name of Representative'><span class='input-group-btn'><button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\""+id+"\", \"Wala\")'><span class='ace-icon fa fa-plus icon-on-right bigger-110'></span></button></span></div>";
			}else{
				divappend += "<div class='input-group'><input type='text' class='form-control "+trap+"' placeholder='(999)-999-9999'><span class='input-group-btn'><button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\""+id+"\", \""+trap+"\")'><span class='ace-icon fa fa-plus icon-on-right bigger-110'></span></button></span></div>";
			}
		}
		$("#"+id).html(divappend);
		$('.MobileNumber').mask('(999) 999-9999');
		$('.TelephoneNumber').mask('(99)-999-9999');
	}

	function div_AddNewFieldDocument(){
		var count = $("#AccredDocCount").val();
		count++;
		$("#txtDocument").append("<div class='row form-group'>"+
									"<div class='col-md-7'>"+
										"<input type='text' class='form-control' name='AccredDocName"+count+"' placeholder='Document Name'>"+
									"</div>"+
									"<div class='col-md-5'>"+
										"<input type='file' class='txtAccredDoc' name='AccredDoc"+count+"'>"+
									"</div>"+
								"</div>");
		$("#AccredDocCount").val(count);
		$('.txtAccredDoc').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});
	}

	function fncAccredPaymentTypes(){
		var ids = "";
		$("#tblAccredPaymentTypeList tr").each(function(){
			ids += $(this).attr("id")+"|";
		})
		$.ajax({
			type: 'POST',
			url: 'reports/accreditation/class.php',
			data: 'ids=' + ids + '&form=fncAccredPaymentTypes',
			success:function(data){
				$("#mdl_tblAccredPaymentTypeList").html(data);
				$("#mdl_tblAccredPaymentTypeList tr").each(function(){
					$(this).click(function(){
						var id = $(this).find(".ptID").text();
						var ptDESC = $(this).find(".ptDESC").text();
						$("#tblAccredPaymentTypeList").append("<tr id=\""+ id +"\">" +
																"<td>"+ ptDESC +"</td>" +
																"<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#"+id+"\").remove();'><i class='fa fa-trash-o'></i></button></td>" +
															"</tr>");
						$("#"+$(this).attr("id")).remove();
					})
				})  
			}
		})
	}

	function SaveNewAccredPTRef(){
		var PaymentTypeID = $("#txtAccreditationPaymentTypeID").val();
		var PaymentTypeDesc = $("#txtAccreditationPaymentTypeDesc").val();
		$.ajax({
			type: 'POST',
			url: 'reports/accreditation/class.php',
			data: 'PaymentTypeID=' + PaymentTypeID + '&PaymentTypeDesc=' + PaymentTypeDesc + '&form=SaveNewAccredPTRef',
			success:function(data){
				var arr = data.split("|");
				if(arr[0] == "1"){
					showmodal("alert", arr[1], "SaveNewAccredPTRefDone", null, "", null, "0");
				}else{
					showmodal("alert", arr[1], "", null, "", null, "1");
				}
			}
		})
	}

	function SaveNewAccredPTRefDone(){
		$("#txtAccreditationPaymentTypeID").val("");
		$("#txtAccreditationPaymentTypeDesc").val("");
		fncAccredPaymentTypes();
		$("#mdl_AddNewAccredRefPT").modal("hide");
	}

	function confirmSaveandClear(){
		$("#CreateNewAccredSched").modal("hide");
		$("#ServiceChargeNo").click();
		$("#LocalTaxNo").click();
		$("#AccredDocCount").val("1");
		$("#AccredDocCount2").val("1");
		$(".chkNatureOfPos").prop("checked", false);
		$(".chkFileGeneratorStat").prop("checked", false);
		$(".AccredReq").css("border-color","#D5D5D5");
		$("#CreateNewAccredSched :input").val("");
		$("#txtAccredDate").val("<?php echo date('m/d/Y'); ?>");
		$("#txtAccredTenant").prop("disabled", false);
		$("#txtMobileNumber").html("");
		$("#txtTelephoneNumber").html("");
		$("#txtAuthorizedRep").html("");
		$("#txtAccreditorsRep").html("");
		$("#txtMachineNumber").html("");
		$("#tblAccredPaymentTypeList").html("");
		$("#txtDocument").html("");
		tblAccreditation();
	}

	function confirmSaveandClear2(){
		$("#CreateNewAccredSched").modal("hide");
		$("#ServiceChargeNo").click();
		$("#LocalTaxNo").click();
		$("#AccredDocCount").val("1");
		$("#AccredDocCount2").val("1");
		$(".chkNatureOfPos").prop("checked", false);
		$(".chkFileGeneratorStat").prop("checked", false);
		$(".AccredReq").css("border-color","#D5D5D5");
		$("#CreateNewAccredSched :input").val("");
		$("#txtAccredDate").val("<?php echo date('m/d/Y'); ?>");
		$("#txtAccredTenant").prop("disabled", false);
		$("#txtMobileNumber").html("");
		$("#txtTelephoneNumber").html("");
		$("#txtAuthorizedRep").html("");
		$("#txtAccreditorsRep").html("");
		$("#txtMachineNumber").html("");
		$("#tblAccredPaymentTypeList").html("");
		$("#txtDocument").html("");
		tblAccreditation();
		$("#mdl_AccredEntries").modal("hide");
		$("#Passed").prop("checked", true);
		$("#txtNewAccredLogsTime").val("");
		tblAccredLogs();
	}

	function SaveNewAccredSched(){
		var a = 0;
		$(".AccredReq").each(function(){
			if($(this).val() == ""){
				$(this).css("border-color", "#f2a696");
				a++;
			}else{
				$(this).css("border-color", "#D5D5D5");
			}
		})
		var AccredID = $("#AccredID").val();
		var AccredTenant = $("#txtAccredTenant").val();
		var AccredDate = $("#txtAccredDate").val();
		var AccredPartnerName = $("#txtAccredPartnerName").val();
		var AccredPosProvider = $("#txtAccredPosProvider").val();
		var AccredSoftwareVersion = $("#txtAccredSoftwareVersion").val();
		var AccredOperatingSystem = $("#txtAccredOperatingSystem").val();
		var AccredNumberOfPOS = $("#txtAccredNumberOfPOS").val();
		var AccredNatureOfPos = "";
		$(".chkNatureOfPos").each(function(){
			if($(this).is(":checked")){
				AccredNatureOfPos += $(this).attr("id") + "|";
			}
		})
		var b = 0;
		if(AccredNatureOfPos == ""){
			b++;
		}
		var AccredGeneratorStat = "";
		$(".chkFileGeneratorStat").each(function(){
			if($(this).is(":checked")){
				AccredGeneratorStat += $(this).attr("id") + "|";
			}
		})
		var c = 0;
		if(AccredGeneratorStat == ""){
			c++;
		}
		var ServiceCharge = "";
		$(".radServiceCharge").each(function(){
			if($(this).is(":checked")){
				if($(this).attr("id") == "ServiceChargeYes"){
					ServiceCharge = $("#ServiceChargeVal").val();
				}else{
					ServiceCharge = 0;
				}
			}
		})
		var LocalTax = "";
		$(".radLocalTax").each(function(){
			if($(this).is(":checked")){
				if($(this).attr("id") == "LocalTaxYes"){
					LocalTax = $("#LocalTaxVal").val();
				}else{
					LocalTax = 0;
				}
			}
		})
		var AccredRemarks = $("#txtAccredRemarks").val();
		var AccredMobileNumbers = "";
		$("#txtMobileNumber input").each(function(){
			if(!$(this).val().match(/^\s*$/) || $(this).val() != ""){
				AccredMobileNumbers += $(this).val() + "|";
			}
		})
		var AccredTelephoneNumbers = "";
		$("#txtTelephoneNumber input").each(function(){
			if($(this).val() != ""){
				AccredTelephoneNumbers += $(this).val() + "|";
			}
		})
		var AccredAuthorizedRep = "";
		$("#txtAuthorizedRep input").each(function(){
			if(!$(this).val().match(/^\s*$/) || $(this).val() != ""){
				AccredAuthorizedRep += $(this).val() + "|";
			}
		})
		var AccreditorsRep = "";
		$("#txtAccreditorsRep input").each(function(){
			if(!$(this).val().match(/^\s*$/) || $(this).val() != ""){
				AccreditorsRep += $(this).val() + "|";
			}
		})
		var AccredMachineNumbers = "";
		$("#txtMachineNumber input").each(function(){
			if(!$(this).val().match(/^\s*$/) || $(this).val() != ""){
				AccredMachineNumbers += $(this).val() + "|";
			}
		})
		var AccredPaymentTypes = "";
		$("#tblAccredPaymentTypeList tr").each(function(){
			AccredPaymentTypes += $(this).attr("id") + "|";
		})
		var d = 0;
		if(AccredPaymentTypes == ""){
			d++;
		}
		if(a == 0){
			if(b == 0){
				if(c == 0){
					if(d == 0){
						$.ajax({
							type: 'POST',
							url: 'reports/accreditation/class.php',
							data: 'AccredID=' + AccredID + '&AccredTenant=' + AccredTenant + '&AccredDate=' + AccredDate + '&AccredPartnerName=' + AccredPartnerName + '&AccredPosProvider=' + AccredPosProvider + '&AccredSoftwareVersion=' + AccredSoftwareVersion + '&AccredOperatingSystem=' + AccredOperatingSystem + '&AccredNumberOfPOS=' + AccredNumberOfPOS + '&AccredNatureOfPos=' + AccredNatureOfPos + '&AccredGeneratorStat=' + AccredGeneratorStat + '&ServiceCharge=' + ServiceCharge + '&LocalTax=' + LocalTax + '&AccredRemarks=' + AccredRemarks + '&AccredMobileNumbers=' + AccredMobileNumbers + '&AccredTelephoneNumbers=' + AccredTelephoneNumbers + '&AccredAuthorizedRep=' + AccredAuthorizedRep + '&AccreditorsRep=' + AccreditorsRep + '&AccredMachineNumbers=' + AccredMachineNumbers + '&AccredPaymentTypes=' + AccredPaymentTypes + '&form=SaveNewAccredSched',
							success:function(data){
								var arr = data.split("|");
								if(arr[0] == "1"){
									setTimeout(function(){
										showmodal("alert", arr[1], "confirmSaveandClear", null, "", null, "0");
									}, 500)
									$("#AccredID").val(arr[2]);
									var data = new FormData($('#frmAccreditation')[0]);
									$.ajax({
										type: 'POST',
										url: 'reports/accreditation/saveAccreditationDocs.php',
										data: data,
										mimeType: 'multipart/form-data',
										contentType: false,
										cache: false,
										processData: false,
										success:function(data){

										}
									});
								}else{
									setTimeout(function(){
										showmodal("alert", "An error has occured.", "", null, "", null, "1");
									}, 500)
								}
							}
						})
					}else{
						setTimeout(function(){
							showmodal("alert", "Please select payment types.", "", null, "", null, "1");
						}, 500)
					}
				}else{
					setTimeout(function(){
						showmodal("alert", "Please select CSV file generator requirement.", "", null, "", null, "1");
					}, 500)
				}
			}else{
				setTimeout(function(){
					showmodal("alert", "Please select nature of POS.", "", null, "", null, "1");
				}, 500)
			}
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
			
		}
	}

	function EorVAccreditation(AccredID, Action){
		$("#CreateNewAccredSched").modal("show");
		$("#AccredID").val(AccredID);
		$("#AccredID2").val(AccredID);
		$(".frmEditOnly").css("display", "block");
		$("#AccredDocCount").val("1");
		$("#AccredDocCount2").val("1");
		$(".clicktoshowall").each(function(){
			var id = this.id;
			if($("#"+id+" i").hasClass("fa fa-chevron-up")){
				$("#"+id).click();
			}
		})
		$.ajax({
			type: 'POST',
			url: 'reports/accreditation/class.php',
			data: 'form=ShowTenantList',
			success:function(data){
				$("#txtAccredTenant").html(data);
			}
		})
		tblAccredLogs();
		$.ajax({
			type: 'POST',
			url: 'reports/accreditation/class.php',
			data: 'AccredID=' + AccredID + '&form=EorVAccreditation',
			success:function(data){
				var arr = data.split("@");
				$("#txtAccredTenant").val(arr[0]);
				$("#txtAccredDate").val(arr[1]);
				$("#txtAccredPartnerName").val(arr[2]);
				$("#txtAccredPosProvider").val(arr[3]);
				$("#txtAccredSoftwareVersion").val(arr[4]);
				$("#txtAccredOperatingSystem").val(arr[5]);
				$("#txtAccredNumberOfPOS").val(arr[6]);
				if(arr[7] == 0){
					$("#ServiceChargeNo").click();
				}else{
					$("#ServiceChargeYes").click();
					$("#ServiceChargeVal").val(arr[7]);
				}
				if(arr[8] == 0){
					$("#LocalTaxNo").click();
				}else{
					$("#LocalTaxYes").click();
					$("#LocalTaxVal").val(arr[8]);
				}
				var arr2 = arr[9].split("|");
				for(var a = 0; a <= arr2.length; a++){
					$("#" + arr2[a]).prop("checked", true);
				}
				var arr3 = arr[10].split("|");
				for(var b = 0; b <= arr3.length; b++){
					$("#" + arr3[b]).prop("checked", true);
				}
				$("#txtAccredRemarks").val(arr[11]);
				var arr4 = arr[12].split("|");
				var MobileNum = ""; 
				for(var c = 0; c <= arr4.length-2; c++){
					MobileNum += "<input type='text' class='form-control MobileNumber AccredReq' value='"+arr4[c]+"' style='margin-bottom:5px;' placeholder='(999)-999-9999'>";
				}
				$("#txtMobileNumber").html(MobileNum+"<div class='input-group'><input type='text' class='form-control MobileNumber' id='txtMobileNumber' placeholder='(999)-999-9999'><span class='input-group-btn'><button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\"txtMobileNumber\", \"MobileNumber\")'><span class='ace-icon fa fa-plus icon-on-right bigger-110'></span></button></span></div>");
				var arr5 = arr[13].split("|");
				var TelephoneNum = "";  
				for(var d = 0; d <= arr5.length-2; d++){
					TelephoneNum += "<input type='text' class='form-control TelephoneNumber AccredReq' value='"+arr5[d]+"' style='margin-bottom:5px;' placeholder='(99)-999-9999'>";
				}
				$("#txtTelephoneNumber").html(TelephoneNum+"<div class='input-group'><input type='text' class='form-control TelephoneNumber' placeholder='(99)-999-9999'><span class='input-group-btn'><button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\"txtTelephoneNumber\", \"TelephoneNumber\")'><span class='ace-icon fa fa-plus icon-on-right bigger-110'></span></button></span></div>");
				var arr6 = arr[14].split("|");
				var AuthorizedRep = ""; 
				for(var e = 0; e <= arr6.length-2; e++){
					AuthorizedRep += "<input type='text' class='form-control AccredReq' value='"+arr6[e]+"' style='margin-bottom:5px;' placeholder='Name of Representative'>";
				}
				$("#txtAuthorizedRep").html(AuthorizedRep+"<div class='input-group'><input type='text' class='form-control' placeholder='Name of Representative'><span class='input-group-btn'><button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\"txtAuthorizedRep\", \"Wala\")'><span class='ace-icon fa fa-plus icon-on-right bigger-110'></span></button></span></div>");
				var arr7 = arr[15].split("|");
				var AccreditorsRep = "";    
				for(var f = 0; f <= arr7.length-2; f++){
					AccreditorsRep += "<input type='text' class='form-control AccredReq' value='"+arr7[f]+"' style='margin-bottom:5px;' placeholder='Name of Representative'>";
				}
				$("#txtAccreditorsRep").html(AccreditorsRep+"<div class='input-group'><input type='text' class='form-control' placeholder='Name of Representative'><span class='input-group-btn'><button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\"txtAccreditorsRep\", \"Wala\")'><span class='ace-icon fa fa-plus icon-on-right bigger-110'></span></button></span></div>");
				var arr8 = arr[16].split("|");
				var MachineNum = "";    
				for(var g = 0; g <= arr8.length-2; g++){
					MachineNum += "<input type='text' class='form-control AccredReq' value='"+arr8[g]+"' style='margin-bottom:5px;' placeholder='Machine Number'>";
				}
				$("#txtMachineNumber").html(MachineNum+"<div class='input-group'><input type='text' class='form-control' placeholder='Machine Number'><span class='input-group-btn'><button type='button' class='btn btn-sm btn-success btn-round' onclick='div_AddNewField(\"txtMachineNumber\", \"Wala\")'><span class='ace-icon fa fa-plus icon-on-right bigger-110'></span></button></span></div>");
				$("#tblAccredPaymentTypeList").html(arr[17]);
				$("#txtDocument").html(arr[18]);
			}, complete(){
				$('.MobileNumber').mask('(999) 999-9999');
				$('.TelephoneNumber').mask('(99)-999-9999');
				$('.txtAccredDoc').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false
				});
				$("#txtAccredTenant").prop("disabled", true);
				if(Action == "Edit"){
					$(".ViewAccred").prop("disabled", false);
					$("#txtMobileNumber :input").prop("disabled", false);
					$("#txtTelephoneNumber :input").prop("disabled", false);
					$("#txtAuthorizedRep :input").prop("disabled", false);
					$("#txtAccreditorsRep :input").prop("disabled", false);
					$("#txtMachineNumber :input").prop("disabled", false);
					$("#tblAccredPaymentTypeList :input").prop("disabled", false);
					$("#txtDocument :input").prop("disabled", false);
				}else{
					$(".ViewAccred").prop("disabled", true);
					$("#txtMobileNumber :input").prop("disabled", true);
					$("#txtTelephoneNumber :input").prop("disabled", true);
					$("#txtAuthorizedRep :input").prop("disabled", true);
					$("#txtAccreditorsRep :input").prop("disabled", true);
					$("#txtMachineNumber :input").prop("disabled", true);
					$("#tblAccredPaymentTypeList :input").prop("disabled", true);
					$("#txtDocument :input").prop("disabled", true);
				}
			}
		})
	}

	function InputAccredEntries(){
		$("#mdl_AccredEntries").modal("show");
		var AccredDate = $("#txtAccredDate").val();
		$("#AccredDocCount2").val("1");
		$("#AccredLogsID").val("");
		$("#txtNewAccredLogsDate").val(AccredDate);
		$("#div_AccredLogsAttachment").html("<div class='col-md-4'>Attachment</div><div class='col-md-8'><input type='file' class='txtAccredDoc' name='AccredDoc1'></div>");
		$('.txtAccredDoc').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});
	}

	function AppendAccredEntriesAttachment(){
		var count = $("#AccredDocCount2").val();
		count++;
		$("#div_AccredLogsAttachment").append("<div class='col-md-4'></div><div class='col-md-8'><input type='file' class='txtAccredDoc' name='AccredDoc"+count+"'></div>");
		$("#AccredDocCount2").val(count);
		$('.txtAccredDoc').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});
	}

	function SaveNewAccredLogs(){
		var AccredID = $("#AccredID").val();
		var LogDate = $("#txtNewAccredLogsDate").val();
		var LogTime = $("#txtNewAccredLogsTime").val();
		var Result = "";
		$(".radAccredLogsResult").each(function(){
			if($(this).is(":checked")){
				Result = $(this).attr("id");
			}
		})
		$.ajax({
			type: 'POST',
			url: 'reports/accreditation/class.php',
			data: 'AccredID=' + AccredID + '&LogDate=' + LogDate + '&LogTime=' + LogTime + '&Result=' + Result + '&form=SaveNewAccredLogs',
			success:function(data){
				var arr = data.split("|");
				if(arr[0] == "1"){
					if(Result == "Passed"){
						showmodal("alert", arr[1], "confirmSaveandClear2", null, "", null, "0");
					}else{
						showmodal("alert", arr[1], "CloseAndClearNewLogsForm", null, "", null, "0");
					}
					$("#AccredID2").val(AccredID);
					$("#AccredLogsID").val(arr[2]);
					var data = new FormData($('#frmAccreditation2')[0]);
						$.ajax({
							type: 'POST',
							url: 'reports/accreditation/saveAccreditationDocs.php',
							data: data,
							mimeType: 'multipart/form-data',
							contentType: false,
							cache: false,
							processData: false,
							success:function(data){

							}
						});
				}else{
					showmodal("alert", arr[1], "", null, "", null, "1");
				}
			}
		})
	}

	function CloseAndClearNewLogsForm(){
		$("#mdl_AccredEntries").modal("hide");
		$("#Passed").prop("checked", true);
		$("#txtNewAccredLogsTime").val("");
		tblAccredLogs();
	}

	function tblAccredLogs(){
		var AccredID = $("#AccredID").val();
		$.ajax({
			type: 'POST',
			url: 'reports/accreditation/class.php',
			data: 'AccredID=' + AccredID + '&form=ShowtblAccredLogs',
			success:function(data){
				$("#tblAccredLogs").html(data);
			}
		})
	}
</script>