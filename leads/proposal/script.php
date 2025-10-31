<script type="text/javascript">
	$(function(){
		$(".fixTable").tableHeadFixer();
		$("#SubLeadsPROPageCount").val("1");
		loadtblSUbLeadsPRO();
		loadmalllist();
		$("#txtSearchSubLeadsPRO").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#SubLeadsPROPageCount").val("1");
				loadtblSUbLeadsPRO(); 
			}else if ( x == '8' ){
				if($('#txtSearchSubLeadsPRO').val() == ""){
					$("#SubLeadsPROPageCount").val("1");
					loadtblSUbLeadsPRO();
				}
			}
		});
		$("#searchshortcutunit").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#shortcutuserpage").val("1");
				LeadsProShrtctUnit(); 
			}else if ( x == '8' ){
				if($('#searchshortcutunit').val() == ""){
					$("#shortcutuserpage").val("1");
					LeadsProShrtctUnit();
				}
			}
		});
		$("#txtSearchCharges").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				showModalAddCharges(); 
			}else if ( x == '8' ){
				if($('#txtSearchCharges').val() == ""){
					showModalAddCharges();
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
		$(".date-picker").datepicker({
	        autoHide: true,
	        format: 'mm/dd/yyyy',
	        todayHighlight: true
	    });
		var date = new Date();
		date.setDate(date.getDate() - 0);
		$('.jonas-date-picker').datepicker({
		    autoclose: true,
		    todayHighlight: true,
		    format: 'mm/dd/yyyy',
		    startDate: date
		});

        $(".rdoIsRent").click(function(){
			if($(this).is(":checked")){
				if($(this).attr("id") == "Pro-Yes"){
					$("#txtProVatType").prop("disabled", false);
					$("#txtProVatPercentage").removeAttr("readonly");
					$("#txtProVatType").val("");
					$("#txtProVatPercentage").val("");
					$("#txtProVatType").addClass("txtProClear");
					$("#txtProVatPercentage").addClass("txtProClear");
				}else{
					$("#txtProVatType").prop("disabled", true);
					$("#txtProVatPercentage").attr("readonly", "readonly");
					$("#txtProVatType").val("");
					$("#txtProVatPercentage").val("");
					$("#txtProVatType").removeClass("txtProClear");
					$("#txtProVatPercentage").removeClass("txtProClear");
				}
			}
		})
		$(".rdoIsSecDeposit").click(function(){
			if($(this).is(":checked")){
				if($(this).val() == "Monthly"){
					$("#txtProSecurityDeposit").css("text-align", "left");
					$("#txtProSecurityDeposit").unbind("change");
				}else{
					$("#txtProSecurityDeposit").css("text-align", "right");
					$("#txtProSecurityDeposit").change(function(){
				        var x = ($(this).val()).replace(/,/g,"");
				        var v = parseFloat(x||0);
				        $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
				    });
				}
				$("#txtProSecurityDeposit").val("0");
			}
		})
		$(".rdoIsConsDeposit").click(function(){
			if($(this).is(":checked")){
				if($(this).val() == "Monthly"){
					$("#txtProConBondMonth").css("text-align", "left");
					$("#txtProConBondMonth").unbind("change");
				}else{
					$("#txtProConBondMonth").css("text-align", "right");
					$("#txtProConBondMonth").change(function(){
				        var x = ($(this).val()).replace(/,/g,"");
				        var v = parseFloat(x||0);
				        $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
				    });
				}
				$("#txtProConBondMonth").val("0");
			}
		})
		$(".txtSysNumOnly").keydown(function(event) {
	        if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188){

	        }else{
	            if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
	               	event.preventDefault(); 
	            }   
	        }
	    });
	})

	function loadtblSUbLeadsPRO() {
		var key = $("#txtSearchSubLeadsPRO").val();
		var page = $("#SubLeadsPROPageCount").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'key=' + key + '&page=' + page + '&form=loadtblSUbLeadsPRO',
			beforeSend : function() {
				$('#indexloadingscreen').addClass('myspinner');
			},
			success: function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				if(data != ""){
					$("#tblSUbLeadsPRO").html(data);
				}else{
					$("#tblSUbLeadsPRO").html("<tr><td colspan='8' style='text-align: center;'>No Data Found...</td></tr>");
				}
				loadtblSUbLeadsPROPagination();
				loadtblSUbLeadsPROEntries();
			}
		});
	}

	function loadtblSUbLeadsPROEntries() {
		var key = $("#txtSearchSubLeadsPRO").val();
		var page = $("#SubLeadsPROPageCount").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'key=' + key + '&page=' + page + '&form=loadtblSUbLeadsPROEntries',
			success: function(data){
				$("#txtSubLeadsProEnt").text(data);
			}
		});
	}

	function loadtblSUbLeadsPROPagination() {
	 	var key = $("#txtSearchSubLeadsPRO").val();
	  	var page = $("#SubLeadsPROPageCount").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'key=' + key + '&page=' + page + '&form=loadtblSUbLeadsPROPagination',
			success: function(data){
				$("#ulSubLeadsProPage").html(data);
			}
		})
	}

	function loadtblSUbLeadsPROPageFunc(page, pagenums) {
		$(".pgnumptnts").removeClass("active");
		$("#pgptnts" + pagenums).addClass("active");
		$("#SubLeadsPROPageCount").val(page);
		loadtblSUbLeadsPRO();
	}
	
	function loadProposalFilter(module){
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
					$('input:checkbox[id="chkMonday"][value="'+arr[i]+'"]').attr('checked', 'checked');
				}
				$("#txtSubLeadsPROStartDate").val(arr2[0]);
				$("#txtSubLeadsPROEndDate").val(arr2[1]);
				for(var i=0; i<=arr3.length-1; i++){
					$('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
				}
				for(var i=0; i<=arr4.length-1; i++){
					$('input:checkbox[id="filter_'+arr4[i]+'"][value="'+arr4[i]+'"]').attr('checked', 'checked');
				}
			}
		})
	}

	function saveProposalFilter() {
		var module = "Proposal";
		var checked = "";
		$('input:checkbox[name="form-field-SubLeadsPRO"]').each(function(){
			if($(this).is(":checked")) {
				var value = $(this).attr("value");
				checked += value + "|";
			}
		})
		var checked2 = "";
		$('input:checkbox[name="form-field-SubLeadsPRO"]').each(function(){
			var value2 = $(this).attr("value");
			checked2 += value2 + "|";
		})
		var checked3 = "";
		$('input:checkbox[name="form-field-SubLeadsPROStat"]').each(function(){
			if($(this).is(":checked")) {
				var value3 = $(this).attr("value");
				checked3 += value3 + "|";
			}
		})
		var xcheck = "";
		var Date1 = $("#txtSubLeadsPROStartDate").val();
		var Date2 = $("#txtSubLeadsPROEndDate").val();
		$.ajax({
			type: 'POST',
			url: 'filter/class.php',
			data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&xcheck=' + xcheck + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
			success: function(data){
				loadtblSUbLeadsPRO();
				$("#LINK_Proposal_filter").click();
			}
		})
	}

	function EditSubLeadsPro(TradeID, CompanyID, InquiryID, UnitID, MallID, UnitType, Action){
		fncAllClassificationRef();
		fncAllSource();
		fncAllProcessOwner();
		$("#clicktoshowall").prop("checked", false);
        $("#clicktoshowall").prop("disabled", false);
		$(".clicktoshowall").each(function(){
        	var id = this.id;
            if($("#"+id+" i").hasClass("fa fa-chevron-up")){
                $("#"+id).click();
            }
        })
		$("#modal_addnewinquiry").modal("show");
		$("#txtSubLeadsProStat").val(Action);
		selecttenant(CompanyID, TradeID);
		displayProposal(InquiryID);
		fncLoadRemarks(InquiryID);
		fncLoadInqOtherInfo(InquiryID)
		$("#txtSubLeadsINQID").val(InquiryID);
		$("#txtPASSInquiryID").val(InquiryID);
		$("#txtProMallID").val(MallID);
		$("#btn_savenewremark").attr("onclick", "savenewremark(\""+InquiryID+"\")");
		$("#shortcutuserpage").val("1");
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'InquiryID=' + InquiryID + '&form=EditSubLeadsPro',
			success:function(data){
				var arr = data.split("|");
				$("#txtinq_createdby").text(arr[1]);
				$("#txtinq_datecreated").text(arr[0]);
				$("#txtinq_modifby").text(arr[3]);
				$("#txtinq_modifdate").text(arr[2]);
				if(arr[0].trim() != "" || arr[1].trim() != ""){
					$(".updatedby_texts").css("display", "block");
				}else{
					$(".updatedby_texts").css("display", "none");
				}
				if(arr[2].trim() != "" || arr[3].trim() != ""){
					$(".modified_info").css("display", "block");
				}else{
					$(".modified_info").css("display", "none");
				}
			}
		})
		if(Action == "apply"){
			$(".frmProDis").prop("disabled", false);
		}else{
			$(".frmProDis").prop("disabled", true);
		}
        <?php if(SysLeaseSetup('softwaretype') == "5"){ ?> 
        	$("#btn_finaloffer").css("display", "none");
			$("#btn_sendReservation").css("display", "inline-block");
        <?php }else{ ?> 
        	$("#btn_finaloffer").css("display", "inline-block");
			$("#btn_sendReservation").css("display", "none");
        <?php } ?>
	}

	function fncLoadInqOtherInfo(InquiryID){
		$.ajax({
			type: 'POST',
			url: 'leads/inquiry/class.php',
			data: 'InquiryID=' + InquiryID + '&form=fncLoadInqOtherInfo',
			success: function(data){
				var arr = data.split("|");
				$("#txtInqSource").val(arr[0]);
				$("#txtInqProcessOwner").val(arr[1]);
				$("#txtInqClassification").val(arr[2]);
				$.ajax({
					type: 'POST',
					url: 'mainclass.php',
					data: 'Classification=' + arr[2] + '&form=fncAllDepartmentRef',
					success: function(data){
						$("#txtInqDepartment").html(data);
					}, complete: function(){
						$("#txtInqDepartment").val(arr[3]);
						$.ajax({
							type: 'POST',
							url: 'mainclass.php',
							data: 'Department=' + arr[3] + '&form=fncAllCategoryRef',
							success: function(data){
								$("#txtInqCategory").html(data);
							}, complete: function(){
								$("#txtInqCategory").val(arr[4]);
							}
						})
					}
				})
			}
		})
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
				$("#txtInqSource").html(data);
			}
		})
	}

	function fncAllProcessOwner(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=fncAllProcessOwner',
			success: function(data){
				$("#txtInqProcessOwner").html(data);
			}
		})
	}

	function SubLeadsProViewHistory(inquiryID){
		$("#modal_SubLeadsProViewHistory").modal("show");
		var module = "Proposal Module";
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'LogID=' + inquiryID + '&module=' + module + '&form=ViewAllHistory',
			success: function(data){
				$("#SubLeadsProViewHistory").html(data);
			}
		})
	}

	function selecttenant(companyID, tradeID){
  		$.ajax({
    		type: 'POST',
			url: 'leads/proposal/class.php',
   	 		data: 'companyID=' + companyID + '&tradeID=' + tradeID +'&form=selecttenant',
    		success: function(data){
      			var arr = data.split("|");
      			$("#txtinq_companyname").attr("value",companyID);
      			$("#txtinq_tradename").attr("value",tradeID);
      			$("#txtinq_tradename").val(arr[0]);
      			$("#txtinq_companyname").val(arr[1]);
      			$("#txtinq_industryname").val(arr[2]);
    		}
  		});
	  	// $.ajax({
		  //   type: 'POST',
		  //   url: 'mainclass.php',
		  //   data: 'companyID=' + companyID + '&tradeID=' + tradeID +'&form=selectcontactnumbers',
		  //   success: function(data){
		  //     	$("#div_inquiry_contact_numbers").html(data);
		  //   }
	  	// });
	  	$.ajax({
		    type: 'POST',
		    url: 'mainclass.php',
		    data: 'tradeID=' + tradeID +'&form=fncgetTradeContact',
		    success: function(data){
		    	if(data != ""){
                    $("#div_inquiry_contact_person").html(data);
                }else{
                    $("#div_inquiry_contact_person").html('<center><img src="assets/images/network.png" style="margin: 20px;height: 120px; width: 120px;"><h3>No contact persons yet.</h3></center>');
                }
		    }
	  	});
	}

	function CloseSubLeadsPro(){
		$("#modal_addnewinquiry").modal("hide");
	}

	function CloseSubLeadsProUnitInfo(){
		$("#mdl-unit-info").modal("hide");
	}

	function displayProposal(inquiryID){
		var type = $("#txtSubLeadsProStat").val();
		$.ajax ({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'type=' + type + '&inquiryID=' + inquiryID + '&form=displayProposal',
			success: function(data) {
				$("#tblproposals").html(data);
			}
		})
	}

	function selectProUnitInfo(inquiryID, UnitID, ProID, UnitType, action){
		$("#mdl-unit-info").modal("show");
		$("#clicktoshowall2").prop("checked", false);
        $("#clicktoshowall2").prop("disabled", false);
		$(".clicktoshowall2").each(function(){
        	var id = this.id;
            if($("#"+id+" i").hasClass("fa fa-chevron-up")){
                $("#"+id).click();
            }
        })
        if(UnitType == "SET"){
			clickLeadsLInqSET();
		}else{
			clickLeadsLInqLCA();
		}
    	SelectThisUnit(UnitID);
		$("#proposalCount").val(ProID);
		var advdate = "";
		var pterms = "";
        $.ajax({
        	type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'inquiryID=' + inquiryID + '&ProID=' + ProID + '&form=DisplayProInfo',
			success:function(data){
				var arr = data.split("@");
				if(arr[0] == "" || arr[0] == "01/01/1970"){
					$("#txtinq_datefrom").val("<?php echo date('m/d/Y'); ?>");
				}else{
					$("#txtinq_datefrom").val(arr[0]);
				}
				$("#txtinq_dateto").val(arr[1]);
				$("#txtnoofmonths_inq").val(arr[2]);
				$("#txtnoofdays_inq").val(arr[3]);
				$("#txtinq_pymenttype").val(arr[7]);
				$("#txtinq_pymentterms").val(arr[8]);
				pterms = arr[8];
				showOccupancyDateTo();
				$("#txtProEscalationRate").val(arr[9]);
				$("#txtProEscaRateStart").val(arr[10]);
				$("#txtProRentFreeCons").val(arr[11]);
				DelProRentConsStarDate(arr[11]);
				$("#txtProConBondMonth").val(arr[12]);
				$("#txtProConBondMonthTerms").val(arr[13]);
				$("#txtProSecurityDeposit").val(arr[14]);
				$("#txtProSecurityDepositTerms").val(arr[15]);
				$("#txtProAdvanceMonthTerms").val(arr[16]);
				advdate = arr[17];
				$("#sonyxperiaxzs").val(arr[21].trim());
				$("#txtProEscaYearBasis").val(arr[27]);
				$("#txtProRentFreeConsStartDate").val(arr[28]);
				$.ajax({
					type: 'POST',
					url: 'leads/proposal/class.php',
					data: 'charges_list=' + arr[18] + '&form=getcharges_list',
					success:function(data){
						$("#tblProCharges").html(data);
						if(action == "view"){
							$(".isFinal").prop("disabled", true);
							$(".isFinal2").attr("readonly", "readonly");
						}else{
							$(".isFinal").prop("disabled", false);
							$(".isFinal2").removeAttr("readonly");
						}
					}
				})
				$.ajax({
					type: 'POST',
					url: 'leads/proposal/class.php',
					data: 'requirement_list=' + arr[19] + '&form=getrequirement_list',
					success:function(data){
						$("#tblProRequirements").html(data);
						if(action == "view"){
							$(".isFinal").prop("disabled", true);
							$(".isFinal2").attr("readonly", "readonly");
						}else{
							$(".isFinal").prop("disabled", false);
							$(".isFinal2").removeAttr("readonly");
						}
					}
				})
				$.ajax({
					type: 'POST',
					url: 'leads/proposal/class.php',
					data: 'permit_list=' + arr[20] + '&form=getpermit_list',
					success:function(data){
						$("#tblProPermits").html(data);
						if(action == "view"){
							$(".isFinal").prop("disabled", true);
							$(".isFinal2").attr("readonly", "readonly");
						}else{
							$(".isFinal").prop("disabled", false);
							$(".isFinal2").removeAttr("readonly");
						}
					}
				})
				$.ajax({
					type: 'POST',
					url: 'mainclass.php',
					data: 'ids=' + arr[21] + '&form=AddSelectedTermsandCon',
					success:function(data){
						$("#tblMainProTermsandCon").html(data);
					}
				})
				$(".rdoIsRent").each(function(){
					if(arr[22] == $(this).val()){
						$(this).prop("checked", true);
					}
				})
				$("#txtProVatType").val(arr[23]);
				$("#txtProVatPercentage").val(arr[24]);
				$(".rdoIsConsDeposit").each(function(){
					if(arr[25].trim() == $(this).val()){
						$(this).prop("checked", true);
					}
				})
				$(".rdoIsSecDeposit").each(function(){
					if(arr[26].trim() == $(this).val()){
						$(this).prop("checked", true);
					}
				})
				if(arr[29].trim() == "" || arr[29].trim() == "01/01/1970"){
					$("#txtinqBillStart").val("<?php echo date('m/d/Y'); ?>");
				}else{
					$("#txtinqBillStart").val(arr[29]);
				}
			}, complete(){
				setTimeout(function(){
					var getdate = advdate.split("#");
			      	for(var i = 0; i<=getdate.length-2; i++){
			          	var getdate2 = getdate[i].split("P");
			          	$("#tblProPaySched").find("tr[id='"+getdate2[0]+"']").removeClass('unselected');
			          	$("#tblProPaySched").find("tr[id='"+getdate2[0]+"']").addClass('selected');
			          	var thistr = $("#tblProPaySched").find("tr[id=\""+getdate2[0]+"\"]");
			          	thistr.find(".chk_advpyment").prop("checked", true);
			          	var chkbox = thistr.find(".chk_advpyment");
			          	var amnt = thistr.find(".lblamntsetup");
			          	var txtadvc = thistr.find(".txtadvpyment");
			          	var lbladvc = thistr.find(".lbladvpyment");
			          	if(chkbox.is(":checked")){
			            	txtadvc.css("display", "block");
			            	if(pterms == "monthly" || pterms == "daily"){
			              		txtadvc.val(getdate2[1]);
			              		lbladvc.text(getdate2[1]);
			              		txtadvc.prop("disabled", true);
			              		lbladvc.css("display", "none");
			              		thistr.removeClass("unselected");
			              		thistr.addClass("selected");
			              		txtadvc.attr("onkeyup", "");
			            	}else{
			              		txtadvc.val(getdate2[1]);
			              		txtadvc.attr("onkeyup", "countallselectedmonth()");
			              		lbladvc.text("0.00");
			              		txtadvc.prop("disabled", true);
			              		lbladvc.css("display", "none");
			              		txtadvc.focus();
			              		thistr.removeClass("unselected");
			              		thistr.addClass("selected");
			            	}
			            	countallselectedmonth();
			          	}else{
			            	txtadvc.attr("onkeyup", "");
			            	txtadvc.css("display", "none");
			            	txtadvc.prop("disabled", true);
			            	lbladvc.text("0.00");
			            	lbladvc.css("display", "block");
			            	txtadvc.val("");
			            	countallselectedmonth();
			            	thistr.removeClass("selected");
			            	thistr.addClass("unselected");
			          	}
			    	}
			    	if(action == "view"){
						$(".isFinal").prop("disabled", true);
						$(".isFinal2").attr("readonly", "readonly");
						setTimeout(function(){
							$("#tblProPaySched tr td").unbind("click");
						}, 1500)
					}else{
						$(".isFinal").prop("disabled", false);
						$(".isFinal2").removeAttr("readonly");
						setTimeout(function(){
							$(".rdoIsRent").each(function(){
								if($(this).is(":checked")){
									if($(this).attr("id") == "Pro-Yes"){
										$("#txtProVatType").prop("disabled", false);
										$("#txtProVatPercentage").removeAttr("readonly");
									}else{
										$("#txtProVatType").prop("disabled", true);
										$("#txtProVatPercentage").attr("readonly", "readonly");
									}
								}
							})
						}, 1500)
					}
				}, 1500)
			}
        })
	}

	function getRentAssoc(UnitID){
		var arr = 0;
		$.ajax({
			type: 'POST',
			async: false,
			url: 'leads/proposal/class.php',
			data: 'UnitID=' + UnitID + '&form=getRentAssoc',
			success:function(data){
				arr = data.trim();
			}
		})
		return arr;
	}

	function loadmalllist(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success: function(data){
				$("#txtProMallID").html(data);
			}, complete: function(){
				LeadsProShrtctUnit();
			}
		})
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

	function clicktoshowall2(){
		$("#clicktoshowall2").each(function(){
			if($(this).is(":checked")){
				$(".clicktoshowall2").click();
			}else{
				$(".clicktoshowall2").click();
			}
		})
	}

	function clickLeadsLInqSET(){
		$("#div_unit_area_set").css("display", "block");
		$("#div_unit_area_lca").css("display", "none");
		$("#div_nodays").css("display", "none");
		$(".txtProClear2").val("");
		$("#div_SubLeadsProAmenities").html("");
		$("#tblProPaySched").html("");
	}

	function clickLeadsLInqLCA(){
		<?php if(SysLeaseSetup('floorandunitmeasurement') == 'Area'){ ?>
			$("#div_unit_area_lca").css("display", "none");
			$("#div_unit_area_set").css("display", "block");
		<?php }else{ ?>
			$("#div_unit_area_lca").css("display", "block");
			$("#div_unit_area_set").css("display", "none");
		<?php } ?>
		$("#div_nodays").css("display", "block");
		$(".txtProClear2").val("");
		$("#div_SubLeadsProAmenities").html("");
		$("#tblProPaySched").html("");
	}

	function addNewProposal(){
        <?php if(SysLeaseSetup('softwaretype') == "5"){ ?> 
        	$("#mdl_PASS").modal("show");
        	$("#txtPASSproposalCount").val("");
        	fncclickPassInqSET();
        <?php }else{ ?> 
        	$("#mdl-unit-info").modal("show");
			$("#mdl-unit-info").find(".form-control").val("");
			$(".for-payments").removeAttr("disabled");
			$("#proposalCount").val("");
			$("#tblMainProTermsandCon").html("");
			$("#tblProRequirements").html("");
			$("#tblProPermits").html("");
			clickLeadsLInqSET();
			$("#txtinq_datefrom").val("<?php echo date('m/d/Y'); ?>");
			$("#clicktoshowall2").prop("checked", false);
	        $("#clicktoshowall2").prop("disabled", false);
			$(".clicktoshowall2").each(function(){
	        	var id = this.id;
	            if($("#"+id+" i").hasClass("fa fa-chevron-up")){
	                $("#"+id).click();
	            }
	        })
	        $.ajax({
				type: 'POST',
				url: 'mainclass.php',
				data: 'form=getDefaultCharges',
				success:function(data){
					$("#tblProCharges").html(data);
				}
			})
			$("#sonyxperiaxzs").val("");
        <?php } ?> 
	}

	function setDefault(id){
		showmodal("confirm", "Are you sure you want to set this as active?", "setDefault1", id+"|", "", null, "1");
	}

	function setDefault1(id){
		var inquiryID = $("#txtSubLeadsINQID").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'id=' + id + '&inquiryID=' + inquiryID + '&form=setDefault',
			success: function(data){
				$("#mdl-unit-info").modal("hide");
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Successfully set as active", "displayProposal", inquiryID+"|", "", null, "0");
					}, 500)
				}
			}
		});
	}

	function sendFinalOffer(){
		showmodal("confirm", "Are you sure you want to send this to leasing?", "sendFinalOffer2", "", "", null, "1");
	}

	function sendFinalOffer2(){
		var inquiryID = $("#txtSubLeadsINQID").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'inquiryID=' + inquiryID + '&form=sendFinalOffer',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Successfully sent to leasing.", "mdlSendToFinalOffer", null, "", null, "0");
					}, 500)
				}else if(data == 2){
					setTimeout(function(){
						showmodal("alert", "Please set your default proposal first.", "", null, "", null, "1");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to save.", "", null, "", null, "1");
					}, 500)
				}
			}
		});
	}

	function mdlSendToFinalOffer(){
		loadtblSUbLeadsPRO();
		$("#modal_addnewinquiry").modal("hide");
	}

	function saveProposal(){
		var id = $("#proposalCount").val();
		var MallID = $("#txtpro_mallbranch").val();
		var unitID = $("#txtinq_unitunitid").val();
		var deptID = $("#txtinq_unitdepartmentid").val();
		var inquiryID = $("#txtSubLeadsINQID").val();
		var cat_id = $("#txtinq_unitcategoryid").val();
		var dateFrom = $("#txtinq_datefrom").val();
		var dateTo = $("#txtinq_dateto").val();
		var BillStartDate = $("#txtinqBillStart").val();
		var UnitType = $("#txtinq_UnitType").val();
		var persqm = $("#txtinq_persqm").val().replace(/,/g, "");
		var monthlyDues = $("#txtinq_totalsqm").val().replace(/,/g, "");
		var unitwing = $("#txtinq_unitwingid").val();
		var unitfloor = $("#txtinq_unitfloorid").val();
		var classid = $("#txtinq_unitclassid").val();
		var monthnum = $("#txtnoofmonths_inq").val();
		var daynum = $("#txtnoofdays_inq").val();
		var dailyDues = 0; //$("#txtmonthlymathdays").val().replace(/,/g, "");
        <?php if(SysLeaseSetup('isAssocDues') == "1"){ ?> 
		var assocdues = $("#txtinq_assocdues").val().replace(/,/g, "");
		<?php }else{ ?>
		var assocdues = 0;
		<?php } ?>
		var pymentterms = $("#txtinq_pymentterms").val();
		var pymenttype = $("#txtinq_pymenttype").val();
		var EscalationRate = $("#txtProEscalationRate").val();
		var EscaRateStart = $("#txtProEscaRateStart").val();
		var EscaYearBasis = $("#txtProEscaYearBasis").val();
		var RentFreeCons = $("#txtProRentFreeCons").val();
		var RentFreeConsStartDate = $("#txtProRentFreeConsStartDate").val();
		var ConBondMonth = $("#txtProConBondMonth").val().replace(/,/g, "");
		var ConBondMonthTerms = $("#txtProConBondMonthTerms").val();
		var SecurityDeposit = $("#txtProSecurityDeposit").val().replace(/,/g, "");
		var SecurityDepositTerms = $("#txtProSecurityDepositTerms").val();
		var AdvanceMonthAmountTerms = $("#txtProAdvanceMonthTerms").val();
		var TermsandCon = $("#sonyxperiaxzs").val();
		var VatType = $("#txtProVatType").val();
		var VatPercent = $("#txtProVatPercentage").val();
		var isRent = "";
		$(".rdoIsRent").each(function(){
			if($(this).is(":checked")){
				isRent = $(this).val();
			}
		})
		var isSecDeposit = "";
		$(".rdoIsSecDeposit").each(function(){
			if($(this).is(":checked")){
				isSecDeposit = $(this).val();
			}
		})
		var isConDeposit = "";
		$(".rdoIsConsDeposit").each(function(){
			if($(this).is(":checked")){
				isConDeposit = $(this).val();
			}
		})
		var SelectedAdv = "";
		$("#tblProPaySched .selected").each(function(){
          	SelectedAdv += $(this).attr("id") + "P" + $(this).find(".txtadvpyment").val() +"#";
        })
        var Charges = "";
		$("#tblProCharges tr").each(function(){
			Charges += $(this).attr("id") + "|";
		})
		var Requirements = "";
		$("#tblProRequirements tr").each(function(){
			Requirements += $(this).attr("id") + "|";
		})
		var Permits = "";
		$("#tblProPermits tr").each(function(){
			Permits += $(this).attr("id") + "|";
		})
		var count = 0;
		$(".txtProClear").each(function(){
			if($(this).val() == "" || $(this).val() == "null"){
				count++;
			}
		})
		if(count == 0){
			if(Charges != ""){
            	<?php if(SysLeaseSetup('reqandpermit') == "1"){ ?> 
				if(Requirements != ""){
					if(Permits != ""){
				<?php } ?>
						if(TermsandCon != ""){
							$.ajax({
								type: 'POST',
								url: 'leads/proposal/class.php',
								data: 'MallID=' + MallID + '&unitID=' + unitID + '&deptID=' + deptID + '&cat_id=' + cat_id + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&BillStartDate=' + BillStartDate + '&UnitType=' + UnitType + '&unitwing=' + unitwing + '&unitfloor=' + unitfloor + '&classid=' + classid + '&inquiryID=' + inquiryID + '&monthnum=' + monthnum + '&daynum=' + daynum + '&pymentterms=' + pymentterms + '&pymenttype=' + pymenttype + '&monthlyDues=' + monthlyDues + '&dailyDues=' + dailyDues + '&assocDues=' + assocdues + '&id=' + id + '&EscalationRate=' + EscalationRate + '&EscaRateStart=' + EscaRateStart + '&RentFreeCons=' + RentFreeCons + '&ConBondMonth=' + ConBondMonth + '&SecurityDeposit=' + SecurityDeposit + '&SelectedAdv=' + encodeURIComponent(SelectedAdv) + '&Charges=' + encodeURIComponent(Charges) + '&Requirements=' + encodeURIComponent(Requirements) + '&Permits=' + encodeURIComponent(Permits) + '&ConBondMonthTerms=' + ConBondMonthTerms + '&SecurityDepositTerms=' + SecurityDepositTerms + '&AdvanceMonthAmountTerms=' + AdvanceMonthAmountTerms + '&TermsandCon=' + encodeURIComponent(TermsandCon) + '&VatType=' + VatType + '&VatPercent=' + VatPercent + '&isRent=' + isRent + '&isSecDeposit=' + isSecDeposit + '&isConDeposit=' + isConDeposit + '&EscaYearBasis=' + EscaYearBasis + '&RentFreeConsStartDate=' + RentFreeConsStartDate + '&form=saveProposal',
								success: function(data){
									$("#mdl-unit-info").modal("hide");
									if(data == 1){
										showmodal("alert", "Successfully Added", "displayProposal", inquiryID+"|", "", null, "0");
									}else if(data == 2){
										showmodal("alert", "Successfully Updated", "displayProposal", inquiryID+"|", "", null, "0");
									}
								}
							});
						}else{
							setTimeout(function(){
								showmodal("alert", "Please select terms and conditions.", "", null, "", null, "1");
							}, 500)
						}
            	<?php if(SysLeaseSetup('reqandpermit') == "1"){ ?> 
					}else{
						setTimeout(function(){
							showmodal("alert", "Please select permits.", "", null, "", null, "1");
						}, 500)
					}
				}else{
					setTimeout(function(){
						showmodal("alert", "Please select requirements.", "", null, "", null, "1");
					}, 500)
				}
				<?php } ?>
			}else{
				setTimeout(function(){
					showmodal("alert", "Please select monthly charges.", "", null, "", null, "1");
				}, 500)
			}
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function LeadsProShrtctUnit(){
		var MallID = $("#txtProMallID").val();
		var page = $("#shortcutuserpage").val();
		var UnitType = "";
		$(".rdoShortucutUnit").each(function(){
			if($(this).is(":checked")){
				UnitType = $(this).val();
			}
		})
		var key = $("#searchshortcutunit").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'UnitType=' + UnitType + '&MallID=' + MallID + '&page=' + page + '&key=' + key + '&form=LeadsProShrtctUnit',
			beforeSend : function() {
				$('#preloadshortcutunit').addClass('myspinner');
			},
			success: function(data){
				$('#preloadshortcutunit').removeClass('myspinner');
				if(data.trim() != "") {
					$("#tblselectshortcutunit").html(data);
				}else{
					$("#tblselectshortcutunit").html("<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>");
				}
				LeadsProShrtctUnitEntries();
				LeadsProShrtctUnitPagination();
			}
		})
	}

	function LeadsProShrtctUnitEntries(){
		var MallID = $("#txtProMallID").val();
		var page = $("#shortcutuserpage").val();
		var UnitType = "";
		$(".rdoShortucutUnit").each(function(){
			if($(this).is(":checked")){
				UnitType = $(this).val();
			}
		})
		var key = $("#searchshortcutunit").val();
		$.ajax({
		  	type: 'POST',
		  	url: 'leads/proposal/class.php',
		  	data: 'UnitType=' + UnitType + '&MallID=' + MallID + '&page=' + page + '&key=' + key + '&form=LeadsProShrtctUnitEntries',
		  	success: function(data){
			  	$("#shortcutentries").text(data);
		  	}
		});
  	}

  	function LeadsProShrtctUnitPagination(){
		var MallID = $("#txtProMallID").val();
		var page = $("#shortcutuserpage").val();
		var UnitType = "";
		$(".rdoShortucutUnit").each(function(){
			if($(this).is(":checked")){
				UnitType = $(this).val();
			}
		})
		var key = $("#searchshortcutunit").val();
		$.ajax({
	  		type: 'POST',
	  		url: 'leads/proposal/class.php',
	  		data: 'UnitType=' + UnitType + '&MallID=' + MallID + '&page=' + page + '&key=' + key + '&form=LeadsProShrtctUnitPagination',
	  		success: function(data){
				$("#ulshortcutpagination").html(data);
	  		}
		});
  	}

  	function btnLeadsProShrtctUnit(page, pagenums){
		$(".pgnumLeadsProShrtctUnit").removeClass("active");
		$("#pgLeadsProShrtctUnit" + pagenums).addClass("active");
		$("#shortcutuserpage").val(page);
		LeadsProShrtctUnit();
  	}

  	function SelectThisUnit(unitid){
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'unitid=' + unitid + '&form=SelectThisUnit',
			success:function(data){
				var arr = data.split("|");
				$("#txtinq_unitclassid").val(arr[0]);
				$("#txtinq_unitclass").val(arr[1]);
				$("#txtinq_unitdepartmentid").val(arr[2]);
				$("#txtinq_unitdepartment").val(arr[3]);
				$("#txtinq_unitcategoryid").val(arr[4]);
				$("#txtinq_unitcategory").val(arr[5]);
				$("#txtinq_unitwingid").val(arr[6]);
				$("#txtinq_unitwing").val(arr[7]);
				$("#txtinq_unitfloorid").val(arr[8]);
				$("#txtinq_unitfloor").val(arr[9]);
				$("#txtinq_unitunitid").val(arr[10]);
				$("#txtinq_unitunit").val(arr[11]);
				$("#txtinq_sqm").val(arr[12]);
				$("#txtinq_sqm_width").val(arr[13]);
				$("#txtinq_sqm_length").val(arr[14]);
				$("#txtinq_persqm").val(arr[15]);
				var arr2 = getRentAssoc(unitid).split("|");
				if(arr[16].replace(/,/g, "") == arr2[0]){ // if rent is modified
					$("#txtinq_totalsqm").val(parseFloat(arr2[0]).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
				}else{
					$("#txtinq_totalsqm").val(arr[16]);
				}
				if(arr[17].replace(/,/g, "") == arr2[1]){ // if assoc is modified
					$("#txtinq_assocdues").val(parseFloat(arr2[1]).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
				}else{
					$("#txtinq_assocdues").val(arr[17]);
				}
				$("#txtmonthlymath").val(arr[18]);
				$("#txtpro_mallbranch").val(arr[19]);
				$("#txtinq_mallname").val(arr[20]);
				$("#txtinq_UnitType").val(arr[21].trim());
				if(arr[21].trim() == "SET"){
					$("#div_unit_area_set").css("display", "block");
					$("#div_unit_area_lca").css("display", "none");
					$("#div_nomonths").css("display", "block");
					$("#div_nodays").css("display", "none");
				}else{
					<?php if(SysLeaseSetup('floorandunitmeasurement') == 'Area'){ ?>
						$("#div_unit_area_lca").css("display", "none");
						$("#div_unit_area_set").css("display", "block");
					<?php }else{ ?>
						$("#div_unit_area_lca").css("display", "block");
						$("#div_unit_area_set").css("display", "none");
					<?php } ?>
					$("#div_nomonths").css("display", "block");
					$("#div_nodays").css("display", "block");
				}
			},
			complete: function(){
				getProPaySched();
				$('#modalshortcutunit').modal('hide');
			}
		})
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'unit_id=' + unitid + '&form=selected_unit_amenities',
			success:function(data){
				$("#div_SubLeadsProAmenities").html(data);
			}
		})
		$("#mdl_ProUnitInfo").modal("hide");
	}

	function Enabletxtinq_totalsqm(){
		$("#txtinq_totalsqm").removeAttr("readonly");
		$("#btnEnabletxtinq_totalsqm").css("display", "block");
	}

	function Disabletxtinq_totalsqm(){
		$("#txtinq_totalsqm").attr("readonly", "readonly");
		$("#btnEnabletxtinq_totalsqm").css("display", "none");
		showOccupancyDateTo();
	}

	function Enabletxtinq_assocdues(){
		$("#txtinq_assocdues").removeAttr("readonly");
		$("#btnEnabletxtinq_assocdues").css("display", "block");
	}

	function Disabletxtinq_assocdues(){
		$("#txtinq_assocdues").attr("readonly", "readonly");
		$("#btnEnabletxtinq_assocdues").css("display", "none");
		showOccupancyDateTo();
	}

	function showOccupancyDateTo(){
		var datefrom = $("#txtinq_datefrom").val();
		var months = $("#txtnoofmonths_inq").val();
		var days = $("#txtnoofdays_inq").val();
		var monthlydues = $("#txtinq_totalsqm").val().replace(/,/g, "");
		<?php if(SysLeaseSetup('isAssocDues') == "1"){ ?> 
		var assocdues = $("#txtinq_assocdues").val().replace(/,/g, "");
		<?php }else{ ?>
		var assocdues = 0;
		<?php } ?>
		var UnitType = $("#txtinq_UnitType").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'monthlydues=' + monthlydues + '&assocdues=' + assocdues + '&UnitType=' + UnitType + '&days=' + days + '&months=' + months + '&datefrom=' + datefrom + '&form=showOccupancyDateTo',
			success:function(data){
				var arr = data.split("|");
				$("#txtinq_dateto").val(arr[0]);
				$("#txtmonthlymathdays").val(arr[2]);
				$("#txtmonthlymath").val(arr[3]);
			}, complete(){
				getProPaySched();
			}
		})
	}

	function showModalAddCharges(){
		var ids = "";
		$("#tblProCharges tr").each(function(){
			ids += $(this).attr("id")+"|";
		})
		var key = $("#txtSearchCharges").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'key=' + key + '&ids=' + ids + '&form=showModalAddCharges',
			success:function(data){
				if(data.trim() == ""){
					$("#tblAddCharges").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblAddCharges").html(data);
					$("#tblAddCharges tr").each(function(){
						$(this).click(function(){
							var id = $(this).find(".ChargesID").text();
							var ChargesDesc = $(this).find(".ChargesDesc").text();
							var ChargesRate = $(this).find(".ChargesRate").text();
							$("#tblProCharges").append("<tr id=\""+ id +"\">" +
															"<td>"+ ChargesDesc +"</td>" +
															"<td>"+ ChargesRate +"</td>" +
															"<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#"+id+"\").remove();'><i class='fa fa-trash-o'></i></button></td>" +
														"</tr>");
							$("#"+$(this).attr("id")).remove();
						})
					})  
				}
			}
		})
	}

	function showModalAddRequirements(){
		var ids = "";
		$("#tblProRequirements tr").each(function(){
			ids += $(this).attr("id")+"|";
		})
		var key = $("#txtSearchRequirement").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'key=' + key + '&ids=' + ids + '&form=showModalAddRequirements',
			success:function(data){
				if(data.trim() == ""){
					$("#tblAddRequirements").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblAddRequirements").html(data);
					$("#tblAddRequirements tr").each(function(){
						$(this).click(function(){
							var id = $(this).find(".RequirementsID").text();
							var RequirementsDesc = $(this).find(".RequirementsDesc").text();
							$("#tblProRequirements").append("<tr id=\""+ id +"\">" +
															"<td>"+ RequirementsDesc +"</td>" +
															"<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#"+id+"\").remove();'><i class='fa fa-trash-o'></i></button></td>" +
														"</tr>");
							$("#"+$(this).attr("id")).remove();
						})
					}) 
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
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'key=' + key + '&ids=' + ids + '&form=showModalAddPermits',
			success:function(data){
				if(data.trim() == ""){
					$("#tblAddPermits").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblAddPermits").html(data);
					$("#tblAddPermits tr").each(function(){
						$(this).click(function(){
							var id = $(this).find(".RequirementsID").text();
							var RequirementsDesc = $(this).find(".RequirementsDesc").text();
							$("#tblProPermits").append("<tr id=\""+ id +"\">" +
															"<td>"+ RequirementsDesc +"</td>" +
															"<td style='text-align: center;z-index: 0;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#"+id+"\").remove();'><i class='fa fa-trash-o'></i></button></td>" +
														"</tr>");
							$("#"+$(this).attr("id")).remove();
						})
					})  
				}
			}
		})
	}

	function getProPaySched(){
		var noofmonths = $("#txtnoofmonths_inq").val();
		var noofdays = $("#txtnoofdays_inq").val();
		var monthlydue = $("#txtinq_totalsqm").val().replace(/,/g, "");
		<?php if(SysLeaseSetup('isAssocDues') == "1"){ ?> 
		var assocdues = $("#txtinq_assocdues").val().replace(/,/g, "");
		<?php }else{ ?>
		var assocdues = 0;
		<?php } ?>
		var UnitType = $("#txtinq_UnitType").val();
		var PTerms = $("#txtinq_pymentterms").val();
		var BillingStartDate = $("#txtinqBillStart").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'noofmonths=' + noofmonths + '&noofdays=' + noofdays + '&monthlydue=' + monthlydue + '&assocdues=' + assocdues + '&UnitType=' + UnitType + '&PTerms=' + PTerms + '&BillingStartDate=' + BillingStartDate + '&form=getProPaySched',
			beforeSend:function(){
				$("#LoadPaySchedule").addClass("myspinner");
			},
			success:function(data){
				$("#LoadPaySchedule").removeClass("myspinner");
				$("#tblProPaySched").html(data);
				tblProPaySchedFunction();
			},complete:function(){
				var subtotal  = 0;
				$("#tblProPaySched tr").each(function(){
					subtotal += parseFloat($(this).find("td").eq(4).text().replace(/,/g,""));
				});
				$("#txtinq_totalmonthlydues").val(subtotal.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
			}
		})
	}

	function tblProPaySchedFunction(){
		var PTerms = $("#txtinq_pymentterms").val();
		$("#tblProPaySched tr").each(function(){
			var eto = $(this);
			var chkbox = eto.find(".chk_advpyment");
			var amnt = eto.find(".lblamntsetup");
	        var txtadvc = eto.find(".txtadvpyment");
	        var lbladvc = eto.find(".lbladvpyment");
			eto.find(".dipwede").click(function(){
				if(eto.hasClass("selected")){
					chkbox.prop("checked", false);
					eto.removeClass("selected");
	                eto.addClass("unselected");
					txtadvc.attr("onkeyup", "");
	              	txtadvc.css("display", "none");
	              	txtadvc.attr("readonly", "readonly");
	              	lbladvc.text("0.00");
	              	lbladvc.css("display", "block");
	              	txtadvc.val("");
	              	countallselectedmonth();
				}else{
					eto.addClass("selected");
					eto.removeClass("unselected");
					chkbox.prop("checked", true);
					txtadvc.css("display", "block");
	              	if(PTerms == "monthly" || PTerms == "daily"){
	                	txtadvc.val(amnt.text());
	                	lbladvc.text(amnt.text());
	                	txtadvc.attr("readonly", "readonly");
	                	lbladvc.css("display", "none");
	                	txtadvc.attr("onkeyup", "");
	              	}else{
	                    txtadvc.val("");
	                    txtadvc.attr("onkeyup", "countallselectedmonth()");
	                    lbladvc.text("0.00");
	                    txtadvc.removeAttr("readonly");
	                    lbladvc.css("display", "none");
	                    txtadvc.focus();
	              	}
	              	countallselectedmonth();
				}
			})
		})
	}

	function countallselectedmonth(){
	  	var paymentterms = $("#txtinq_pymentterms").val();
	  	var i = 0;
	  	var amt = 0;
		$("#tblProPaySched tr").each(function(){
		    var chk_advpyment = $(this).find(".chk_advpyment");
		    if(paymentterms == "1time"){
		      	var txtadvpyment = parseInt(($(this).find(".txtadvpyment").val())||0);
		    }else{
		     	var txtadvpyment = parseInt(($(this).find(".txtadvpyment").val()).replace(/,/g, "")||0);
		    }
		    if(chk_advpyment.is(":checked")){
		      	i++;
		      	amt+=txtadvpyment;
		    }
		});
	  	$("#txtProAdvanceMonth").val(i);
	  	$("#txtProAdvanceAmount").val(amt.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
	}

	function showModal_mdl_ProTermsAndCon(){
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'form=showModal_mdl_ProTermsAndCon',
			success:function(data){
				$("#txtProSearchGroup").html(data);
			}, complete(){
				loadModalTermsandCond();
			}
		})
	}

	function loadModalTermsandCond(){
		var key = $("#txtProSearchGroup").val();
		var page = $("#mdlProTermsandCon").val();
		$.ajax({
			type: 'POST',
			url: 'leads/proposal/class.php',
			data: 'page=' + page + '&key=' + key + '&form=loadModalTermsandCond',
			beforeSend:function(){
				$("#divmdlProTermsAndCon").addClass("myspinner");
			},
			success:function(data){
				$("#divmdlProTermsAndCon").removeClass("myspinner");
				$("#tblProTermsAndCon").html(data);
				$("#tblProTermsAndCon tr").each(function(){
					$(this).click(function(){
						eto = $(this).find(".chkProselectedTAC");
						if(eto.is(":checked")){
							var ids = $("#sonyxperiaxzs").val();
							eto.prop("checked", false);
							$("#sonyxperiaxzs").val(ids.replace($(this).find(".chkProselectedTAC").val() + "|", ""));
							$(this).css("color","");
							$(this).css("background-color","");
						}else{
							var ids = $("#sonyxperiaxzs").val();
							eto.prop("checked", true);
							ids += $(this).find(".chkProselectedTAC").val() + "|";
							$("#sonyxperiaxzs").val(ids);
							$(this).css("color","#FFF");
							$(this).css("background-color","#666");
						}
					})
				})
			}, complete(){
				checkSelected();
			}
		})
	}

	function checkSelected(){
		var allselected = $("#sonyxperiaxzs").val();
		var arr = allselected.split("|");
		for ( var a = 0; a <= arr.length-2; a++ ) {
			$(".chkProselectedTAC" + arr[a]).prop("checked", true);
			$("#tr"+arr[a]).attr("style","background-color: #666 !important;color:#FFF !important");
		}
	}

	function AddSelectedProTermsandCon(){
		var ids = "";
		$(".chkProselectedTAC").each(function(){
			if($(this).is(":checked")){
				ids += this.value + "|";
			}	
		})
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'ids=' + ids + '&form=AddSelectedTermsandCon',
			success:function(data){
				$("#tblMainProTermsandCon").html(data);
				$("#mdl_ProTermsAndCon").modal("hide");
			}
		})
	}

	function printProposal(mallid, ownername, tradename, floor, mall, unitname, sqmunitsetup, leaseperiod, basicrent, rentfreecons, escalationrate, paymenttype, securitydeposit, advancerent, constructiondeposit, charges_list, reqlist, perlist, inquiryID, proposalNum, PrintType){
		// $.ajax({
		// 	type: 'POST',
		// 	url: 'mainclass.php',
		// 	data: ''
		// 	success: function(data){

		// 	}
		// })
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'mallID=' + mallid + '&form=getheaderprint',
			success:function(data){
				$("#template").html(data);
			}
		})
		$("#txtProPrintOwnername").text(ownername);
		$("#txtProPrintTradename").text(tradename);
		$("#txtProPrintFloor").text(floor);
		$("#txtProPrintMallname").text(mall);
		$("#txtProUnitNo").text(unitname);
		$("#txtProFloorArea").text(sqmunitsetup);
		$("#txtProLeasePeriod").text(leaseperiod);
		$("#txtProBasicRent").text(basicrent);
		$("#txtProRentFreeConPer").text(rentfreecons);
		$("#txtProEscalationRatePrint").text(escalationrate);
		$("#txtProModeofPayment").text(paymenttype);
		$("#txtPrintProSecurityDeposit").text(securitydeposit);
		$("#txtProAdvanceRent").text(advancerent);
		$("#txtProConstructionDeposit").text(constructiondeposit);
		var dataTrigger1 = "";
		var dataTrigger2 = "";
		var dataTrigger3 = "";
		var dataTrigger4 = "";
		if(PrintType == "All"){
			$.ajax({
				type: 'POST',
				async: false,
				url: 'leads/proposal/class.php',
				data: 'charges_list=' + charges_list + '&form=getcharges_list2',
				success:function(data){
					$("#PrintProOpeCha").html(data);
					if(data.trim() == ""){
						dataTrigger1 = "0";
						$(".isOpeChargeNotBlank").css("display", "none");
					}else{
						dataTrigger1 = "1";
						$(".isOpeChargeNotBlank").css("display", "table");
					}
				}
			})
			$.ajax({
				type: 'POST',
				async: false,
				url: 'leads/proposal/class.php',
				data: 'charges_list=' + charges_list + '&form=getcharges_list3',
				success:function(data){
					$("#PrintProConCha").html(data);
					if(data.trim() == ""){
						dataTrigger2 = "0";
						$(".isConChargeNotBlank").css("display", "none");
					}else{
						dataTrigger2 = "1";
						$(".isConChargeNotBlank").css("display", "table");
					}
				}
			})
			if(dataTrigger1 == "0" && dataTrigger2 == "0"){
				$("#isOpeConChargeNotBlank").css("display", "none");
			}else{
				$("#isOpeConChargeNotBlank").css("display", "block");
			}
			$.ajax({
				type: 'POST',
				async: false,
				url: 'leads/proposal/class.php',
				data: 'reqlist=' + reqlist + '&form=PrintReqList',
				success:function(data){
					$("#PrintReqList").html(data);
					if(data.trim() == ""){
						dataTrigger3 = "0";
						$(".isReqNotBlank").css("display", "none");
					}else{
						dataTrigger3 = "1";
						$(".isReqNotBlank").css("display", "table");
					}
				}
			})
			$.ajax({
				type: 'POST',
				async: false,
				url: 'leads/proposal/class.php',
				data: 'perlist=' + perlist + '&form=PrintPerList',
				success:function(data){
					$("#PrintPerList").html(data);
					if(data.trim() == ""){
						dataTrigger4 = "0";
						$(".isPerNotBlank").css("display", "none");
					}else{
						dataTrigger4 = "1";
						$(".isPerNotBlank").css("display", "table");
					}
				}
			})
			if(dataTrigger3 == "0" && dataTrigger4 == "0"){
				$("#isReqPerNotBlank").css("display", "none");
			}else{
				$("#isReqPerNotBlank").css("display", "block");
			}
			$.ajax({
				type: 'POST',
				url: 'leads/proposal/class.php',
				data: 'inquiryID=' + inquiryID + '&proposalNum=' + proposalNum + '&form=PrintProTermsandCond',
				success:function(data){
					$("#tbodyLeaseProposal").html(data);
				}
			})
			$.ajax({
				type: 'POST',
				url: 'leads/proposal/class.php',
				data: 'mallid=' + mallid + '&form=PrintProSigList',
				success:function(data){
					$("#tbodyProSigList").html(data);
				}
			})
			$.ajax({
				type: 'POST',
				url: 'leads/proposal/class.php',
				data: 'mallid=' + mallid + '&form=PrintProSigList2',
				success:function(data){
					$("#tbodyProSigList2").html(data);
				}
			})
		}else if(PrintType == "Charges"){
			$("#isReqPerNotBlank").css("display", "none");
			$(".isReqNotBlank").css("display", "none");
			$(".isPerNotBlank").css("display", "none");
			$.ajax({
				type: 'POST',
				async: false,
				url: 'leads/proposal/class.php',
				data: 'charges_list=' + charges_list + '&form=getcharges_list2',
				success:function(data){
					$("#PrintProOpeCha").html(data);
					if(data.trim() == ""){
						dataTrigger1 = "0";
						$(".isOpeChargeNotBlank").css("display", "none");
					}else{
						dataTrigger1 = "1";
						$(".isOpeChargeNotBlank").css("display", "table");
					}
				}
			})
			$.ajax({
				type: 'POST',
				async: false,
				url: 'leads/proposal/class.php',
				data: 'charges_list=' + charges_list + '&form=getcharges_list3',
				success:function(data){
					$("#PrintProConCha").html(data);
					if(data.trim() == ""){
						dataTrigger2 = "0";
						$(".isConChargeNotBlank").css("display", "none");
					}else{
						dataTrigger2 = "1";
						$(".isConChargeNotBlank").css("display", "table");
					}
				}
			})
			if(dataTrigger1 == "0" && dataTrigger2 == "0"){
				$("#isOpeConChargeNotBlank").css("display", "none");
			}else{
				$("#isOpeConChargeNotBlank").css("display", "block");
			}
		}else if(PrintType == "Requirements"){
			$("#isOpeConChargeNotBlank").css("display", "none");
			$(".isOpeChargeNotBlank").css("display", "none");
			$(".isConChargeNotBlank").css("display", "none");
			$.ajax({
				type: 'POST',
				async: false,
				url: 'leads/proposal/class.php',
				data: 'reqlist=' + reqlist + '&form=PrintReqList',
				success:function(data){
					$("#PrintReqList").html(data);
					if(data.trim() == ""){
						dataTrigger3 = "0";
						$(".isReqNotBlank").css("display", "none");
					}else{
						dataTrigger3 = "1";
						$(".isReqNotBlank").css("display", "table");
					}
				}
			})
			$.ajax({
				type: 'POST',
				async: false,
				url: 'leads/proposal/class.php',
				data: 'perlist=' + perlist + '&form=PrintPerList',
				success:function(data){
					$("#PrintPerList").html(data);
					if(data.trim() == ""){
						dataTrigger4 = "0";
						$(".isPerNotBlank").css("display", "none");
					}else{
						dataTrigger4 = "1";
						$(".isPerNotBlank").css("display", "table");
					}
				}
			})
			if(dataTrigger3 == "0" && dataTrigger4 == "0"){
				$("#isReqPerNotBlank").css("display", "none");
			}else{
				$("#isReqPerNotBlank").css("display", "block");
			}
		}else if(PrintType == "TermsAndConditions"){
			$("#isOpeConChargeNotBlank").css("display", "none");
			$(".isOpeChargeNotBlank").css("display", "none");
			$(".isConChargeNotBlank").css("display", "none");
			$("#isReqPerNotBlank").css("display", "none");
			$(".isReqNotBlank").css("display", "none");
			$(".isPerNotBlank").css("display", "none");
			$.ajax({
				type: 'POST',
				url: 'leads/proposal/class.php',
				data: 'inquiryID=' + inquiryID + '&proposalNum=' + proposalNum + '&form=PrintProTermsandCond',
				success:function(data){
					$("#tbodyLeaseProposal").html(data);
				}
			})
		}
		
		
		setTimeout(function(){
			var toprint = $("#divLeaseProposalForm").html();
	        var myheight = $(window).height()-40;
	        var mywidth = $(window).width()-40;
	        var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
	        popupWin.document.open();
	        popupWin.document.write("<html><head><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
	        popupWin.document.close();
		}, 2000)
	}

	function DelProRentConsStarDate(kasunduan){
		if(kasunduan == 0){
			$("#divConsStartDate").css("display", "none");
			$("#txtProRentFreeConsStartDate").removeClass("txtProClear");
		}else{
			$("#divConsStartDate").css("display", "block");
			$("#txtProRentFreeConsStartDate").addClass("txtProClear");
		}
	}

	function ViewUnitInformation(UnitID){
    	$("#mdl_ProUnitInfo").modal("show");
    	$.ajax({
    		type: 'POST',
	  		url: 'mainclass.php',
	  		data: 'UnitID=' + UnitID + '&form=ViewUnitInformation',
	  		success: function(data){
	  			$("#divProUnitListContainer").html(data);
	  		}, complete: function(){
	  			var colorbox_params = {
		          	rel: 'colorbox',
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
				$('[data-rel="colorbox"]').colorbox(colorbox_params);
				$('#cboxLoadingGraphic').append("<i class='ace-icon fa fa-spinner orange'></i>");
	  		}
    	})
    }

    function fncChangeSelectID(UnitID){
    	$("#btnChangeSelectID").attr("onclick", "SelectThisUnit(\""+ UnitID +"\")");
    	$.ajax({
    		type: 'POST',
    		url: 'mainclass.php',
    		data: 'UnitID=' + UnitID + '&form=fncChangeSelectID',
    		success: function(data){
    			$("#divColorBox-"+UnitID).html(data);
    		}, complete: function(){
	  			var colorbox_params = {
		          	rel: 'colorbox-' + UnitID,
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
				$('[data-rel="colorbox-'+ UnitID +'"]').colorbox(colorbox_params);
				$('#cboxLoadingGraphic').append("<i class='ace-icon fa fa-spinner orange'></i>");
	  		}
    	})
    }
</script>