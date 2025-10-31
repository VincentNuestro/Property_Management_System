<script type="text/javascript">
	$(function(){
		daterangepicker();
		getefacilities();
		timepickers();
		numbers();



	});	

	function fnccreateeventsx(InquiryID,typex){
		$("#btnprintevents").hide();
		$("#mdlAddNewInquiry").modal('hide');
		cleareventsform();
		getcompanylistx();
		$("#btnsaveeventsx").attr("onclick", "fncSavesaveevents(\""+ InquiryID +"\", \""+typex+"\")");
		$("#mdlAddevents").modal('show');
		$(".willhide").hide();
		setTimeout(function(){
			$("#txteventorganizer").val(company).trigger('change');
		}, 500);
	}

	function numbers() {
		$(".numberlang").keydown(function (e) {
		// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
			// Allow: Ctrl+A, Command+A
			(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
			// Allow: home, end, left, right, down, up
			(e.keyCode >= 35 && e.keyCode <= 40)) {
			// let it happen, don't do anything
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
	}

	function timepickers(){
		$('.timepickeronly').datetimepicker({
			format: 'LT'
		});
	}

	function daterangepicker(){
		$('input[name="date-range-picker"]').daterangepicker({
		  autoUpdateInput: false,
		  locale: {
		      cancelLabel: 'Clear'
		  }
		});

		$('input[name="date-range-picker"]').on('apply.daterangepicker', function(ev, picker) {
		  $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});

		$('input[name="date-range-picker"]').on('cancel.daterangepicker', function(ev, picker) {
		  $(this).val('');
		});

	}


	function frmeventformop(InquiryID,typex,company,isdisabled,proposalNum = '',propstat = ''){
		collapseIcon();
		showEvents();
		cleareventsform();
		$("#mdlAddevents").modal('show');
		getcompanylistx();
		$("#btnsaveeventsx").attr("onclick", "fncSavesaveevents(\""+ InquiryID +"\", \""+proposalNum+"\")");
		$("#btnsaveeventsnotedby").attr("onclick", "fncopenmodalnotedby(\""+ InquiryID +"\")");
		$("#btnprintevents").show();
		$("#btnprintevents2").attr("onclick","$arr = [];$arr.push( 'InquiryID="+InquiryID+"');$arr.push( 'proposalNum="+proposalNum+"');$arr.push( 'key=');getheaderprintx('<?php echo $_SESSION['MMS-Designation']; ?>','newprintevents',JSON.stringify($arr));");
		$("#btnprintevents").attr("onclick","$arr = [];$arr.push( 'InquiryID="+InquiryID+"');$arr.push( 'proposalNum="+proposalNum+"');$arr.push( 'key=');getheaderprintx('<?php echo $_SESSION['MMS-Designation']; ?>','printableevents',JSON.stringify($arr));");
		$("#btnaddremarksevents").attr("onclick", "addnewremarks_events(\""+ InquiryID +"\")");
		if(typex==0){
			$("#headerevents").hide();	
			$("#accordeventremarks").hide();
			$(".willhide").hide();
			$(".willhide2").hide();
			setTimeout(function(){
				$("#txteventorganizer").val(company).trigger('change');
				checkifhasalreadyevents(InquiryID);
			}, 500);
			
			
		}else{
			$("#accordeventremarks").show();
			$(".willhide").show();
			formdisplayevents(InquiryID,proposalNum);
			fncLoadUnitevents(InquiryID,proposalNum);
			if(propstat=='1'){
				$(".willhide2").show();
			}else{
				$(".willhide2").hide();
			}
			
		}
		if(isdisabled==0){
			$(".edisabled").prop('disabled',false);
		}else{
			$(".edisabled").prop('disabled','disabled');
		}
		
	}

	function fncCloseevents(){
		$("#mdlAddevents").modal('hide');
	}

	function setFiles() {
		$('.txtIRImages').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});
	}

	function getcompanylistx(){
		$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'form=getcompanylistx',
			success: function(data) {
				$("#txteventorganizer").html(data);
				$(".searchy_select").select2();
	    		$(".select2-selection").css('height','33px');
			}
		})
	}

	function getefacilities(){
		$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'form=getefacilities',
			success: function(data) {
				$("#txtfacility").html(data);
				$(".searchy_select").select2();
	    		$(".select2-selection").css('height','33px');
			}
		})
	}

	function selectamountfacilities(codex){
		$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'codex=' + codex + '&form=selectamountfacilities',
			success: function(data) {
				$("#txtPrice").val(data);

			}
		})
	}

	function getnametbls(tbl,id,aname){
		var arr = "";
		$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			async:false,
			data:  'tbl=' + tbl + '&id=' + id + '&aname=' + aname + '&form=getnametbls',
			success: function(data) {
				arr = data;
			}
		})
		return arr;
	}
;

	function addFacilities() {
		var count = 0;
		var opt = "";
		$("#forFacilities").find(".required").each(function(){
			var eto = $(this);
			var eto2 = eto.find(".form-control");
			if ( eto2.val() == "" ) {
				count = 1;
				eto.addClass("has-error");
				eto2.click(function(){
					eto.removeClass("has-error");
				})
			}
		})

		if ( count == 0 ) {
			var facilityCode = $("#txtfacility").val();
			var txtfacility =  $('#txtfacility').select2('data');
			var qty = $("#txtQty").val();
			var unit = $("#txtUnit").val();
			var remarks = $("#txtRemarks").val();
			var txtPrice = $("#txtPrice").val();
			var output = "";
			var vat = (parseFloat(txtPrice.replace(/,/g, "")) * parseFloat(qty)) * 0.12;
			var num = (parseFloat(txtPrice.replace(/,/g, "")) * parseFloat(qty)) + parseFloat(vat);
			var cnt = $("#tblFacilities tr").length;
			output += "<tr id='trfacility"+cnt+"'>";
			output += "<td style='display:none'>"+facilityCode+"</td>";
			output += "<td>"+getnametbls('tblref_facilities',facilityCode,'FacilitiesDesc')+"</td>";
			output += "<td style='text-align:right'>"+txtPrice+"</td>";
			output += "<td style='text-align:center'>"+qty+"</td>";
			output += "<td style='text-align:center'>"+unit+"</td>";
			output += "<td style='text-align:right'>"+vat.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+"</td>";
			output += "<td style='text-align:right'>"+num.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+"</td>";
			output += "<td>"+remarks+"</td>";
			output += "<td style='text-align:center'><a onclick='removetr(\"trfacility"+cnt+"\",\"tblFacilities\",6,\"txttotalfacilities\")'><span class='fa fa-times red' style='font-size: 20px;'></span></a></td>";
			output += "</tr>";


			var totalprice = 0;
			$("#tblFacilities").append(output);
			$("#tblFacilities tr").each(function(){
		        var currentRow=$(this);
		        var col6_value=currentRow.find("td:eq(6)").text().replace(/,/g, "");
		        totalprice += parseFloat(col6_value);
		   });
			$("#txttotalfacilities").text(totalprice.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
			//editable();
			$(".toClear").val("");
        	$("#txtfacility").val([]).trigger("change");
        	$(".select2-selection").css('height','33px');

			overalltotalsum();
		} else {
			showmodal('alert', 'Please fill up required fields', '', '', '', '', '1');
		}
	}

	function removetr(ids,tbl,pricenum,txttot){
		$("#"+ids).remove();
		var totalprice = 0;
		$("#"+tbl+" tr").each(function(){
	        var currentRow=$(this);
	        var col6_value=currentRow.find("td:eq("+pricenum+")").text().replace(/,/g, "");
	        totalprice += parseFloat(col6_value);
	   });
		$("#"+txttot).text(totalprice.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		overalltotalsum();
	}

	function overalltotalsum(){
		var tot1 = $("#txttotalfacilities").text().replace(/,/g, "");
		var tot2 = $("#txttotalsound").text().replace(/,/g, "");
		var tot3 =  $("#txttotalmanpower").text().replace(/,/g, "");
		var tot4 = $("#txttotalunitsrent").text().replace(/,/g, "");
		var overall = parseFloat(tot1) + parseFloat(tot2) + parseFloat(tot3) + parseFloat(tot4);
		$("#txteoveralltotal").text(overall.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
	}

	function getefsound(){
		$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'form=getefsound',
			success: function(data) {
				$("#txtPersonnel").html(data);
				$(".searchy_select").select2();
	    		$(".select2-selection").css('height','33px');
			}
		})
	}

	function selectamountpersonnel(codex){
		$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'codex=' + codex + '&form=selectamountpersonnel',
			success: function(data) {
				$("#txtPricepersonnel").val(data);
			}
		})
	}

	function addSound() {
		var count = 0;
		$("#forSound").find(".required").each(function(){
			var eto = $(this);
			var eto2 = eto.find(".form-control");
			if ( eto2.val() == "" ) {
				count = 1;
				eto.addClass("has-error");

				eto2.click(function(){
					eto.removeClass("has-error");
				})
			}
		})

		if ( count == 0 ) {
			var code = $("#txtPersonnel").val();
			var names = $("#txtPersonnel").val();
			var txtstartTimeSound = $("#txtstartTimeSound").val();
			var txtendTimeSound = $("#txtendTimeSound").val();
			var txtRemarksSound = $("#txtRemarksSound").val();
			var txtneedsound = $("#txtneedsound").val();
			var txtQtypersonnel = $("#txtQtypersonnel").val();
			var txtstartTimeSound = $("#txtstartTimeSound").val();
			var txtendTimeSound = $("#txtendTimeSound").val();
			var txtPricepersonnel = $("#txtPricepersonnel").val();
			var txtneedsound = $("#txtneedsound").val();
			var vat = (parseFloat(txtPricepersonnel.replace(/,/g, "")) * parseFloat(txtQtypersonnel)) * 0.12;
			var num = (parseFloat(txtPricepersonnel.replace(/,/g, "")) * parseFloat(txtQtypersonnel)) + parseFloat(vat);
			var my_veriable = $('#txtPersonnel').select2().val();
			var my_last_veriable = my_veriable.toString();
			var cnt = $("#tblSound tr").length;
			var output = "";
			var txtsounddate = $("#txtsounddate").val();
			output += "<tr id='trsound"+cnt+"'>";
			output += "<td style='display:none'>"+code+"</td>";
			output += "<td>"+getnametbls('tblref_soundnper',code,'SoundnperDesc')+"</td>";
			output += "<td style='text-align:center'>"+txtQtypersonnel+"</td>";
			output += "<td style='text-align:right'>"+txtPricepersonnel+"</td>";
			output += "<td style='text-align:right'>"+vat.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+"</td>";
			output += "<td style='text-align:right'>"+num.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+"</td>";
			output += "<td style='text-align:center'>"+txtsounddate+"</td>";
			output += "<td style='text-align:center'>"+txtstartTimeSound+"</td>";
			output += "<td style='text-align:center'>"+txtendTimeSound+"</td>";
			output += "<td style='text-align:center'>"+txtneedsound+"</td>";
			output += "<td>"+txtRemarksSound+"</td>";
			output += "<td style='text-align:center'><a onclick='removetr(\"trsound"+cnt+"\",\"tblSound\",5,\"txttotalsound\")'><span class='fa fa-times red' style='font-size: 20px;'></span></a></td>";
			output += "</tr>";

			

			var totalprice = 0;
			$("#tblSound").append(output);
			$("#tblSound tr").each(function(){
		        var currentRow=$(this);
		        var col6_value=currentRow.find("td:eq(5)").text().replace(/,/g, "");
		        totalprice += parseFloat(col6_value);
		   });
			$("#txttotalsound").text(totalprice.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
			//editable();
			$(".toClear").val("");
        	$("#txtPersonnel").val([]).trigger("change");
        	$(".select2-selection").css('height','33px');

			overalltotalsum();

		} else {
			showmodal('alert', 'Please fill up required fields', '', '', '', '', '1');
		}
	}


	function getefmanpower(){
		$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'form=getefmanpower',
			success: function(data) {
				$("#txtname-manpower").html(data);
				$(".searchy_select").select2();
	    		$(".select2-selection").css('height','33px');
			}
		})
	}

	function selectamountmanpower(codex){
		$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'codex=' + codex + '&form=selectamountmanpower',
			success: function(data) {
				$("#Price-manpower").val(data);
			}
		})
	}


	function addManpower() {
		var count = 0;
		$("#forManpower").find(".required").each(function(){
			var eto = $(this);
			var eto2 = eto.find(".form-control");
			if ( eto2.val() == "" ) {
				count = 1;
				eto.addClass("has-error");

				eto2.click(function(){
					eto.removeClass("has-error");
				})
			}
		})

		if ( count == 0 ) {
			var code = $("#txtname-manpower").val();
			var names = $("#txtname-manpower").val();
			var txtstartTimemanpower = $("#txtstartTimemanpower").val();
			var txtendTimemanpower = $("#txtendTimemanpower").val();
			var paxs = $("#txtPax-manpower").val();
			var needs = $("#txtneedmanpower").val();
			var remarks = $("#txtRemarksmanpower").val();
			var pricex = $("#Price-manpower").val();
			var qty = $("#txtqty-manpower").val();
			var vat = (parseFloat(pricex.replace(/,/g, "")) * (parseFloat(paxs) * parseFloat(qty)) ) * 0.12;
			var num = (parseFloat(pricex.replace(/,/g, "")) * (parseFloat(paxs) * parseFloat(qty)) ) + parseFloat(vat) ;
			var my_veriable = $('#txtname-manpower').select2().val();
			var my_last_veriable = my_veriable.toString();
			var cnt = $("#tblManpower tr").length;
			var output = "";
			var txtmanpowerdate = $("#txtmanpowerdate").val();			
			output += "<tr id='trmanpower"+cnt+"'>";
			output += "<td style='display:none'>"+code+"</td>";
			output += "<td>"+getnametbls('tblref_manpower',code,'ManpowerDesc')+"</td>";
			output += "<td style='text-align:center'>"+paxs+"</td>";
			output += "<td style='text-align:center'>"+qty+"</td>";
			output += "<td style='text-align:right'>"+pricex+"</td>";
			output += "<td style='text-align:right'>"+vat.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+"</td>";
			output += "<td style='text-align:right'>"+num.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+"</td>";
			output += "<td style='text-align:center'>"+txtmanpowerdate+"</td>";
			output += "<td style='text-align:center'>"+txtstartTimemanpower+"</td>";
			output += "<td style='text-align:center'>"+txtendTimemanpower+"</td>";
			output += "<td style='text-align:center'>"+needs+"</td>";
			output += "<td>"+remarks+"</td>";
			output += "<td style='text-align:center'><a onclick='removetr(\"trmanpower"+cnt+"\",\"tblManpower\",6,\"txttotalmanpower\")'><span class='fa fa-times red' style='font-size: 20px;'></span></a></td>";
			output += "</tr>";

			

			var totalprice = 0;
			$("#tblManpower").append(output);
			$("#tblManpower tr").each(function(){
		        var currentRow=$(this);
		        var col6_value=currentRow.find("td:eq(6)").text().replace(/,/g, "");
		        totalprice += parseFloat(col6_value);
		   });
			$("#txttotalmanpower").text(totalprice.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
			//editable();
			$(".toClear").val("");
        	$("#txtname-manpower").val([]).trigger("change");
        	$(".select2-selection").css('height','33px');

			overalltotalsum();


		} else {
			showmodal('alert', 'Please fill up required fields', '', '', '', '', '1');
		}
	}

	function geteforganizer(){
		$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'form=geteforganizer',
			success: function(data) {
				$("#txtname-organizer").html(data);
				$(".searchy_select").select2();
	    		$(".select2-selection").css('height','33px');
			}
		})
	}




	function addOrganizer() {
		var count = 0;
		$("#forOrganizer").find(".required").each(function(){
			var eto = $(this);
			var eto2 = eto.find(".form-control");
			if ( eto2.val() == "" ) {
				count = 1;
				eto.addClass("has-error");

				eto2.click(function(){
					eto.removeClass("has-error");
				})
			}
		})

		if ( count == 0 ) {
			var code = $("#txtname-organizer").val();
			var names = $("#txtname-organizer").val();
			var qty = $("#txtqty-organizer").val();
			var unit = $("#txtunit-organizer").val();
			var remarks = $("#txtremarks-organizer").val();
			var my_veriable = $('#txtname-organizer').select2().val();
			var my_last_veriable = my_veriable.toString();
			var cnt = $("#tblOrganizer tr").length;
			var output = "";
			output += "<tr id='trorganizer"+cnt+"'>";
			output += "<td style='display:none'>"+code+"</td>";
			output += "<td>"+getnametbls('tblref_organizerm',code,'OrganizermDesc')+"</td>";
			output += "<td style='text-align:center'>"+qty+"</td>";
			output += "<td style='text-align:center'>"+unit+"</td>";
			output += "<td>"+remarks+"</td>";
			output += "<td style='text-align:center'><a onclick='removetr(\"trorganizer"+cnt+"\",\"tblOrganizer\",4,\"\")'><span class='fa fa-times red' style='font-size: 20px;'></span></a></td>";
			output += "</tr>";

			$("#tblOrganizer").append(output);
			$(".toClear").val("");
        	$("#txtname-organizer").val([]).trigger("change");
        	$(".select2-selection").css('height','33px');


			
		} else {
			showmodal('alert', 'Please fill up required fields', '', '', '', '', '1');
		}
	}



	function getefpromotional(){
		$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'form=getefpromotional',
			success: function(data) {
				$("#txtname-promotional").html(data);
				$(".searchy_select").select2();
	    		$(".select2-selection").css('height','33px');
			}
		})
	}

	function addPromotional() {
		var count = 0;
		$("#forPromotional").find(".required").each(function(){
			var eto = $(this);
			var eto2 = eto.find(".form-control");
			if ( eto2.val() == "" ) {
				count = 1;
				eto.addClass("has-error");

				eto2.click(function(){
					eto.removeClass("has-error");
				})
			}
		})

		if ( count == 0 ) {
			var code = $("#txtname-promotional").val();
			var names = $("#txtname-promotional").val();
			var remarks = $("#txtremarks-promotional").val();
			var my_veriable = $('#txtname-promotional').select2().val();
			var my_last_veriable = my_veriable.toString();
			var cnt = $("#tblPromotional tr").length;
			var output = "";
			output += "<tr id='trpromotional"+cnt+"'>";
			output += "<td style='display:none'>"+code+"</td>";
			output += "<td>"+getnametbls('tblref_promotionalp',code,'PromotionalpDesc')+"</td>";
			output += "<td>"+remarks+"</td>";
			output += "<td style='text-align:center'><a onclick='removetr(\"trpromotional"+cnt+"\",\"tblPromotional\",4,\"\")'><span class='fa fa-times red' style='font-size: 20px;'></span></a></td>";
			output += "</tr>";

			$("#tblPromotional").append(output);
			$(".toClear").val("");
        	$("#txtname-promotional").val([]).trigger("change");
        	$(".select2-selection").css('height','33px');
		} else {
			showmodal('alert', 'Please fill up required fields', '', '', '', '', '1');
		}
	}


	function opendadddreq(){
        var countx = $("#bodyrequirements .txtIRImages").length + 1;
        $("#bodyrequirements").append('<div class="row  trbodyrequirements">' +
                                            '<div class="cont-files" id="cont-files-'+countx+'">' +
                                               ' <div class="col-sm-1 col-xs-1">' +
                                                    '<span class="fa fa-times red" style="font-size: 24px; cursor: pointer;" onclick="removeTemp(\'cont-files-'+countx+'\')"></span>' +
                                                '</div>' +
                                                '<div class="col-sm-6 col-xs-11">' +
                                                    '<input type="file" name="files[]" class="txtIRImages">' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>');
        var eventsid = $("#lblSNo").text();
        $("#txteventsidno").val(eventsid);
        setTimeout(function(){
			setFiles();
		}, 300)
	}

	function removeTemp(idx){
		$("#"+idx).remove();
	}

	function addDaytoDay() {
		var cnt = $("#activityBody .starting").length + 1;
		var output ='<div class="form-horizontal info-form starting" id="dtod-'+cnt+'">' +
                        '<div class="form-group">' +
                            '<div class="col-md-2 required">' + 
                                '<label class="control-label">Date Duration&nbsp;<span class=" red">*</span></label>' +
                                '<div class="input-group">' +
                                   ' <span class="input-group-addon">' +
                                        '<i class="fa fa-calendar bigger-110"></i>' +
                                   ' </span>' +
                                    '<input class="form-control actdaterange" type="text" name="date-range-picker" id="id-date-range-picker-'+cnt+'" />' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-5 required">' +
                               ' <label class="control-label">Title of Activity &nbsp;<span class=" red">*</span></label>' +
                               ' <input type="text" class="form-control d2dinputs actTitle">' +
                            '</div>' +

                            '<div class="col-md-2 required">' +
                                '<label class="control-label">Start Time &nbsp;<span class=" red">*</span></label>' +
                                '<input type="text" class="form-control d2dinputs timepickeronly actStart" onkeydown="return false">' +
                            '</div>' +

                            '<div class="col-md-2 required">' +
                                '<label class="control-label">End Time &nbsp;<span class=" red">*</span></label>' +
                                '<input type="text" class="form-control d2dinputs timepickeronly actEnd" onkeydown="return false">' +
                            '</div>' +

                            '<div class="col-md-1" style="margin-top: 30px;">' +
                                '<div class="row">' +
                                    '<center>' +
                                        '<span class="fa fa-times red removedtod" style="font-size: 30px;cursor: pointer;" ></span>' +
                                    '</center>'+
                                '</div>'+
                            '</div>'+
                        '</div>' +
                    '</div>';
		$("#activityBody").append(output);
		$(".removedtod").click(function(){
			alert('s');
			$(this).closest("div.starting").remove();
		});
		daterangepicker();
		timepickers();
	
	}

	function fncSavesaveevents(InquiryID,proposalNum = ''){
		$("#btnsaveeventsx").button('loading');
		var txteventname = $("#txteventname").val();
		var txteventstartdate = $("#txteventstartdate").val();
		var txteventenddate = $("#txteventenddate").val();
		var txteventorganizer = $("#txteventorganizer").val();
		var txteventrevtype = $("#txteventrevtype").val();
		var lblSNo =  $("#lblSNo").text();
		var txteventconfirmdate = $("#txteventconfirmdate").val();

		var count = 0;
		$("#btnsaveeventsx").prop('disabled','disabled');
		$("#eventdetails").find(".requiredx").each(function(){
			var eto = $(this);
			var eto2 = eto.find(".form-control");
			if ( eto2.val() == "" ) {
				count = 1;
				eto.addClass("has-error");
				eto2.click(function(){
					eto.removeClass("has-error");
				})
			}
		});
		if ( count == 0 ) {
			var arreventsmanin=[];
			$("#activityBody .starting").each(function(){
			    var currentRow=$(this);

			     col1_value=currentRow.find(".actdaterange").val();
			     col2_value=currentRow.find(".actTitle").val();
			     col3_value=currentRow.find(".actStart").val();
			     col4_value=currentRow.find(".actEnd").val();
			 

			    obj={};
			    obj.col1=col1_value;
			    obj.col2=col2_value;
			    obj.col3=col3_value;
			    obj.col4=col4_value;

			    arreventsmanin.push(obj);
			});
			var arreventsfacilities=[];
			$("#tblFacilities tr").each(function(){
			    currentRow=$(this);

			   	xcol0_value=currentRow.find("td:eq(0)").text();
		        xcol1_value=currentRow.find("td:eq(1)").text();
		        xcol2_value=currentRow.find("td:eq(2)").text().replace(/,/g, "");
		        xcol3_value=currentRow.find("td:eq(3)").text();
		        xcol4_value=currentRow.find("td:eq(4)").text();
		        xcol5_value=currentRow.find("td:eq(5)").text().replace(/,/g, "");
		        xcol6_value=currentRow.find("td:eq(6)").text().replace(/,/g, "");
		        xcol7_value=currentRow.find("td:eq(7)").text();


		        obj={};
		        obj.col0=xcol0_value;
		        obj.col1=xcol1_value;
		        obj.col2=xcol2_value;
		        obj.col3=xcol3_value;
		        obj.col4=xcol4_value;
		        obj.col5=xcol5_value;
		        obj.col6=xcol6_value;
		        obj.col7=xcol7_value;

			    arreventsfacilities.push(obj);
			});
			var arreventssound=[];
			$("#tblSound tr").each(function(){
			    currentRow=$(this);

			   	xcol0_value=currentRow.find("td:eq(0)").text();
		        xcol1_value=currentRow.find("td:eq(1)").text();
		        xcol2_value=currentRow.find("td:eq(2)").text();
		        xcol3_value=currentRow.find("td:eq(3)").text().replace(/,/g, "");
		        xcol4_value=currentRow.find("td:eq(4)").text().replace(/,/g, "");
		        xcol5_value=currentRow.find("td:eq(5)").text().replace(/,/g, "");
		        xcol6_value=currentRow.find("td:eq(6)").text();
		        xcol7_value=currentRow.find("td:eq(7)").text();
		        xcol8_value=currentRow.find("td:eq(8)").text();
		        xcol9_value=currentRow.find("td:eq(9)").text();
		        xcol10_value=currentRow.find("td:eq(10)").text();


		        obj={};
		        obj.col0=xcol0_value;
		        obj.col1=xcol1_value;
		        obj.col2=xcol2_value;
		        obj.col3=xcol3_value;
		        obj.col4=xcol4_value;
		        obj.col5=xcol5_value;
		        obj.col6=xcol6_value;
		        obj.col7=xcol7_value;
		        obj.col8=xcol8_value;
		        obj.col9=xcol9_value;
		        obj.col10=xcol10_value;

			    arreventssound.push(obj);
			});
			var arreventsmanpower=[];
			$("#tblManpower tr").each(function(){
			    currentRow=$(this);

			   	xcol0_value=currentRow.find("td:eq(0)").text();
		        xcol1_value=currentRow.find("td:eq(1)").text();
		        xcol2_value=currentRow.find("td:eq(2)").text();
		        xcol3_value=currentRow.find("td:eq(3)").text()
		        xcol4_value=currentRow.find("td:eq(4)").text().replace(/,/g, "");
		        xcol5_value=currentRow.find("td:eq(5)").text().replace(/,/g, "");
		        xcol6_value=currentRow.find("td:eq(6)").text().replace(/,/g, "");
		        xcol7_value=currentRow.find("td:eq(7)").text();
		        xcol8_value=currentRow.find("td:eq(8)").text();
		        xcol9_value=currentRow.find("td:eq(9)").text();
		        xcol10_value=currentRow.find("td:eq(10)").text();
		        xcol11_value=currentRow.find("td:eq(11)").text();


		        obj={};
		        obj.col0=xcol0_value;
		        obj.col1=xcol1_value;
		        obj.col2=xcol2_value;
		        obj.col3=xcol3_value;
		        obj.col4=xcol4_value;
		        obj.col5=xcol5_value;
		        obj.col6=xcol6_value;
		        obj.col7=xcol7_value;
		        obj.col8=xcol8_value;
		        obj.col9=xcol9_value;
		        obj.col10=xcol10_value;
		        obj.col11=xcol11_value;

			    arreventsmanpower.push(obj);
			});
			var arreventsorganizer=[];
			$("#tblOrganizer tr").each(function(){
			    currentRow=$(this);

			   	xcol0_value=currentRow.find("td:eq(0)").text();
		        xcol1_value=currentRow.find("td:eq(1)").text();
		        xcol2_value=currentRow.find("td:eq(2)").text();
		        xcol3_value=currentRow.find("td:eq(3)").text();
		        xcol4_value=currentRow.find("td:eq(4)").text();


		        obj={};
		        obj.col0=xcol0_value;
		        obj.col1=xcol1_value;
		        obj.col2=xcol2_value;
		        obj.col3=xcol3_value;
		        obj.col4=xcol4_value;

			    arreventsorganizer.push(obj);
			});
			var arreventspromotional=[];
			$("#tblPromotional tr").each(function(){
			    currentRow=$(this);

			   	xcol0_value=currentRow.find("td:eq(0)").text();
		        xcol1_value=currentRow.find("td:eq(1)").text();
		        xcol2_value=currentRow.find("td:eq(2)").text();


		        obj={};
		        obj.col0=xcol0_value;
		        obj.col1=xcol1_value;
		        obj.col2=xcol2_value;

			    arreventspromotional.push(obj);
			});
			
			var countx = $("#bodyrequirements .txtIRImages").length;
			var arreventsrequirements=[];
			$("#newbodyreqs .attachlist").each(function(){
			    var currentRow=$(this);

			     col1_value=currentRow.find(".hidereqid").val();
			     col2_value=currentRow.find(".reqname").val();
			     col3_value=currentRow.find(".hidefullname").val();
			     col4_value=currentRow.find(".hideext").val();
			     col5_value=currentRow.find(".hidepath").val();
			 

			    obj={};
			    obj.col1=col1_value;
			    obj.col2=col2_value;
			    obj.col3=col3_value;
			    obj.col4=col4_value;
			    obj.col5=col5_value;

			    arreventsrequirements.push(obj);
			});
			$.ajax ({
				type: 'POST',
				url: 'global_events/class.php',
				data: 'txteventname=' + encodeURIComponent(txteventname) + '&txteventstartdate=' + txteventstartdate + '&txteventenddate=' + txteventenddate + '&txteventorganizer=' + encodeURIComponent(txteventorganizer) + '&txteventrevtype=' + encodeURIComponent(txteventrevtype) + '&InquiryID=' + InquiryID + '&mainevents=' + JSON.stringify(arreventsmanin) + '&arreventsfacilities=' + JSON.stringify(arreventsfacilities) + '&arreventssound=' +  JSON.stringify(arreventssound) + "&arreventsmanpower=" + JSON.stringify(arreventsmanpower) + '&arreventsorganizer=' +  JSON.stringify(arreventsorganizer) + '&arreventsrequirements=' + JSON.stringify(arreventsrequirements) + '&arreventspromotional=' + JSON.stringify(arreventspromotional)  + '&lblSNo=' + lblSNo + '&txteventconfirmdate=' + txteventconfirmdate + '&proposalNum=' + proposalNum +  '&form=fncSavesaveevents',
				success: function(data) {
					var arr = data.split("|");
					if(arr[0]=='1'){
						$("#mdlAddevents").modal('hide');
						 setTimeout(function(){
	                        showmodal("alert", "Event successfully Saved.", "", "", "", null, "0");
	                    }, 500);
						 setTimeout(function(){
						 	if(countx==0){
						 		window.location.reload();	
						 	}else{

						 		$("#txteventsidno").val(arr[1]);
						 		setTimeout(function(){
			                        $("#btnuploadeventsattach").click();
			                    },500);
						 		
						 	}
	                        
	                    }, 500);
						
					}
				}
			})

		}else{
			showmodal('alert', 'Please fill up required fields', '', '', '', '', '1');
			$("#btnsaveeventsx").prop('disabled',false);
			$("#btnsaveeventsx").button('reset');
		}

	}


	function formdisplayevents(InquiryID,proposalNum,ifexist = ''){
		$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data:  'InquiryID=' + InquiryID + '&proposalNum=' + proposalNum + '&form=formdisplayevents',
			success: function(data) {
				$("#headerevents").show();
				
                var obj = JSON.parse(data);
                if(ifexist==''){
                	$("#lblSNo").text(obj[0].eventid);
	                $("#lblDateCreated").text(obj[0].x_date);
	                $("#lblCreatedBy").text(obj[0].userAdded);
                }
                $("#txteventconfirmdate").val(obj[0].confirmdate);
                $("#txteventname").val(obj[0].eventname);
                $("#txteventstartdate").val(obj[0].startdate);
                $("#txteventenddate").val(obj[0].enddate);
                $("#txteventorganizer").val(obj[0].compCode).trigger('change')
				$("#txteventrevtype").val(obj[0].RevType).trigger('change');
				var tbldaytoday = "";
                var cntdaytoday = $("#activityBody .starting").length + 1;
                $.each(obj[0].daytoday,function(key, value){    
					tbldaytoday += '<div class="form-horizontal info-form starting" id="dtod-'+cntdaytoday+'">' +
			                        '<div class="form-group">' +
			                            '<div class="col-md-2 required">' + 
			                                '<label class="control-label">Date Duration&nbsp;<span class=" red">*</span></label>' +
			                                '<div class="input-group">' +
			                                   ' <span class="input-group-addon">' +
			                                        '<i class="fa fa-calendar bigger-110"></i>' +
			                                   ' </span>' +
			                                    '<input class="form-control actdaterange" type="text" name="date-range-picker" value="'+obj[0].daytoday[key].durationx+'" id="id-date-range-picker-'+cntdaytoday+'" />' +
			                                '</div>' +
			                            '</div>' +
			                            '<div class="col-md-5 required">' +
			                               ' <label class="control-label">Title of Activity &nbsp;<span class=" red">*</span></label>' +
			                               ' <input type="text" value="'+obj[0].daytoday[key].acts+'" class="form-control d2dinputs actTitle">' +
			                            '</div>' +

			                            '<div class="col-md-2 required">' +
			                                '<label class="control-label">Start Time &nbsp;<span class=" red">*</span></label>' +
			                                '<input type="text" value="'+obj[0].daytoday[key].starttime+'" class="form-control d2dinputs timepickeronly actStart" onkeydown="return false">' +
			                            '</div>' +

			                            '<div class="col-md-2 required">' +
			                                '<label class="control-label">End Time &nbsp;<span class=" red">*</span></label>' +
			                                '<input type="text" value="'+obj[0].daytoday[key].endtime+'" class="form-control d2dinputs timepickeronly actEnd" onkeydown="return false">' +
			                            '</div>' +

			                            '<div class="col-md-1" style="margin-top: 30px;">' +
			                                '<div class="row">' +
			                                    '<center>' +
			                                        '<span class="fa fa-times red removedtod" style="font-size: 30px;cursor: pointer;" ></span>' +
			                                    '</center>'+
			                                '</div>'+
			                            '</div>'+
			                        '</div>' +
			                    '</div>';
			        cntdaytoday++;
                });
                $("#activityBody").html(tbldaytoday);
                daterangepicker();
				timepickers();

				var tblfacilities = "";
                var cntfacilities = $("#tblFacilities tr").length + 1;
                var txttotalfacilities = 0;
                $.each(obj[0].facilities,function(key, value){    
					tblfacilities += "<tr id='trfacility"+cntfacilities+"'>";
					tblfacilities += "<td style='display:none'>"+obj[0].facilities[key].facilityID+"</td>";
					tblfacilities += "<td>"+obj[0].facilities[key].facility+"</td>";
					tblfacilities += "<td style='text-align:right'>"+obj[0].facilities[key].facilityprice+"</td>";
					tblfacilities += "<td style='text-align:center'>"+obj[0].facilities[key].qty+"</td>";
					tblfacilities += "<td style='text-align:center'>"+obj[0].facilities[key].facilityUnit+"</td>";
					tblfacilities += "<td style='text-align:right'>"+obj[0].facilities[key].vat+"</td>";
					tblfacilities += "<td style='text-align:right'>"+obj[0].facilities[key].facilitytotal+"</td>";
					tblfacilities += "<td>"+obj[0].facilities[key].facilityRemarks+"</td>";
					tblfacilities += "<td style='text-align:center'><a onclick='removetr(\"trfacility"+cntfacilities+"\",\"tblFacilities\",6,\"txttotalfacilities\")'><span class='fa fa-times red' style='font-size: 20px;'></span></a></td>";
					tblfacilities += "</tr>";
					txttotalfacilities += parseFloat(obj[0].facilities[key].facilitytotal.replace(/,/g, ""));
			        cntfacilities++;
                });
				$("#txttotalfacilities").text(txttotalfacilities.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $("#tblFacilities").html(tblfacilities);

                var tblsound = "";
                var cntsound = $("#tblSound tr").length + 1;
                var txttotalsound = 0;
                $.each(obj[0].soundner,function(key, value){    
					tblsound += "<tr id='trsound"+cntsound+"'>";
					tblsound += "<td style='display:none'>"+obj[0].soundner[key].pCode+"</td>";
					tblsound += "<td>"+obj[0].soundner[key].pName+"</td>";
					tblsound += "<td style='text-align:center'>"+obj[0].soundner[key].pqty+"</td>";
					tblsound += "<td style='text-align:right'>"+obj[0].soundner[key].pprice+"</td>";
					tblsound += "<td style='text-align:right'>"+obj[0].soundner[key].vat+"</td>";
					tblsound += "<td style='text-align:right'>"+obj[0].soundner[key].ptotprice+"</td>";
					tblsound += "<td style='text-align:center'>"+obj[0].soundner[key].datex+"</td>";
					tblsound += "<td style='text-align:center'>"+obj[0].soundner[key].pstarttime+"</td>";
					tblsound += "<td style='text-align:center'>"+obj[0].soundner[key].pendtime+"</td>";
					tblsound += "<td style='text-align:center'>"+obj[0].soundner[key].pneeds+"</td>";
					tblsound += "<td>"+obj[0].soundner[key].premarks+"</td>";
					tblsound += "<td style='text-align:center'><a onclick='removetr(\"trsound"+cntsound+"\",\"tblSound\",5,\"txttotalsound\")'><span class='fa fa-times red' style='font-size: 20px;'></span></a></td>";
					tblsound += "</tr>";
					txttotalsound += parseFloat(obj[0].soundner[key].ptotprice.replace(/,/g, ""));
			        cntsound++;
                });
				$("#txttotalsound").text(txttotalsound.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $("#tblSound").html(tblsound);

                var tblmanpower = "";
                var cntmanpower = $("#tblManpower tr").length + 1;
                var txttotalmanpower = 0;
                $.each(obj[0].manpower,function(key, value){    
					tblmanpower += "<tr id='trmanpower"+cntmanpower+"'>";
					tblmanpower += "<td style='display:none'>"+obj[0].manpower[key].manpowercode+"</td>";
					tblmanpower += "<td>"+obj[0].manpower[key].manpower+"</td>";
					tblmanpower += "<td style='text-align:center'>"+obj[0].manpower[key].pax+"</td>";
					tblmanpower += "<td style='text-align:center'>"+obj[0].manpower[key].qty+"</td>";
					tblmanpower += "<td style='text-align:right'>"+obj[0].manpower[key].mprice+"</td>";
					tblmanpower += "<td style='text-align:right'>"+obj[0].manpower[key].vat+"</td>";
					tblmanpower += "<td style='text-align:right'>"+obj[0].manpower[key].totprice+"</td>";
					tblmanpower += "<td style='text-align:center'>"+obj[0].manpower[key].datex+"</td>";
					tblmanpower += "<td style='text-align:center'>"+obj[0].manpower[key].starttime+"</td>";
					tblmanpower += "<td style='text-align:center'>"+obj[0].manpower[key].endtime+"</td>";
					tblmanpower += "<td style='text-align:center'>"+obj[0].manpower[key].need+"</td>";
					tblmanpower += "<td>"+obj[0].manpower[key].remarks+"</td>";
					tblmanpower += "<td style='text-align:center'><a onclick='removetr(\"trmanpower"+cntmanpower+"\",\"tblManpower\",6,\"txttotalmanpower\")'><span class='fa fa-times red' style='font-size: 20px;'></span></a></td>";
					tblmanpower += "</tr>";
					txttotalmanpower += parseFloat(obj[0].manpower[key].totprice.replace(/,/g, ""));
			        cntmanpower++;
                });
				$("#tblManpower").html(tblmanpower);
				$("#txttotalmanpower").text(txttotalmanpower.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));


				var tblorganize = "";
                var cntorganize = $("#tblOrganizer tr").length + 1;
                var txttotalorganize = 0;
                $.each(obj[0].organizer,function(key, value){    
					tblorganize += "<tr id='trorganizer"+cntorganize+"'>";
					tblorganize += "<td style='display:none'>"+obj[0].organizer[key].orgCode+"</td>";
					tblorganize += "<td>"+obj[0].organizer[key].orgName+"</td>";
					tblorganize += "<td style='text-align:center'>"+obj[0].organizer[key].orgQty+"</td>";
					tblorganize += "<td style='text-align:center'>"+obj[0].organizer[key].orgUnit+"</td>";
					tblorganize += "<td>"+obj[0].organizer[key].orgRemarks+"</td>";
					tblorganize += "<td style='text-align:center'><a onclick='removetr(\"trorganizer"+cntorganize+"\",\"tblOrganizer\",4,\"\")'><span class='fa fa-times red' style='font-size: 20px;'></span></a></td>";
					tblorganize += "</tr>";
			        cntorganize++;
                });
				$("#tblOrganizer").html(tblorganize);

				var tblpromotional = "";
                var cntpromotional = $("#tblPromotional tr").length + 1;
                var txttotalorganize = 0;
                $.each(obj[0].promotional,function(key, value){    
					tblpromotional += "<tr id='trpromotional"+cntpromotional+"'>";
					tblpromotional += "<td style='display:none'>"+obj[0].promotional[key].promotionalid+"</td>";
					tblpromotional += "<td>"+obj[0].promotional[key].promotionaldesc+"</td>";
					tblpromotional += "<td>"+obj[0].promotional[key].remarks+"</td>";
					tblpromotional += "<td style='text-align:center'><a onclick='removetr(\"trpromotional"+cntpromotional+"\",\"tblPromotional\",4,\"\")'><span class='fa fa-times red' style='font-size: 20px;'></span></a></td>";
					tblpromotional += "</tr>";
			        cntpromotional++;
                });
				$("#tblPromotional").html(tblpromotional);

				var tblreqs = "";
                var countx = $("#newbodyreqs .attachlist").length + 1;
                $.each(obj[0].requirements,function(key, value){    
					tblreqs += '<div class="row  attachlist" id="ex-files-'+countx+'">' +
                        '<div class="cont-files" >' +
                           ' <div class="col-sm-1 col-xs-1">' +
                                '<span class="fa fa-times red" style="font-size: 24px; cursor: pointer;" onclick="removeTemp(\'ex-files-'+countx+'\')"></span>' +
                            '</div>' +
                            '<div class="col-sm-6 col-xs-12"><input type="hidden" class="hidereqid" name="" class="form-control" value = "'+obj[0].requirements[key].id+'" ><input type="hidden" class="hidefullname" name="" class="form-control" value = "'+obj[0].requirements[key].fullname+'" ><input type="hidden" class="hidepath" name="" class="form-control" value = "'+obj[0].requirements[key].path+'" ><input type="hidden" class="hideext" name="" class="form-control" value = "'+obj[0].requirements[key].ext+'" >' +
                               '<a  title="Download" style="cursor:pointer" href="'+obj[0].requirements[key].path+obj[0].requirements[key].fullname+'" download><input type="text" style="height: 30px" name="" class="form-control reqname" value = "'+obj[0].requirements[key].name+'" readonly></a>' +
                            '</div>' +
                        '</div>' +
                    '</div>'
			        countx++;
                });
                overalltotalsum();
				$("#newbodyreqs").html(tblreqs);
				setTimeout(function(){
					setFiles();
				}, 300);
				fncLoadRemarksevents(InquiryID,proposalNum);

			}
		})
	}


	function cleareventsform(){
		$("#lblSNo").text("");
        $("#lblDateCreated").text("");
        $("#lblCreatedBy").text("");
        $("#lblCreatedBy").text("");
        $("#txteventname").val("");
        $("#txteventstartdate").val("");
        $("#txteventenddate").val("");
        $("#txteventconfirmdate").val("");
        $("#newbodyreqs").html("");
        $("#bodyrequirements").html("");
        $("#activityBody").html('<div class="form-horizontal info-form starting" id="dtod-1">' +
                                    '<div class="form-group">' +
                                        '<div class="col-md-2 requiredx">' +
                                           '<label class="control-label">Date Duration&nbsp;<span class=" red">*</span></label>' +
                                            '<div class="input-group">' +
                                                '<span class="input-group-addon">' +
                                                    '<i class="fa fa-calendar bigger-110"></i>' +
                                                '</span>' +

                                                '<input class="form-control actdaterange" type="text" name="date-range-picker" />' +
                                            '</div>' +
                                        '</div>' +

                                        '<div class="col-md-5 requiredx">' +
                                            '<label class="control-label">Title of Activity &nbsp;<span class=" red">*</span></label>' +
                                            '<input type="text" class="form-control  actTitle">' +
                                        '</div>' +

                                        '<div class="col-md-2 requiredx">' +
                                            '<label class="control-label">Start Time &nbsp;<span class=" red">*</span></label>' +
                                            '<input type="text" class="form-control  timepickeronly actStart" onkeydown="return false">' +
                                        '</div>' +

                                        '<div class="col-md-2 requiredx">' +
                                            '<label class="control-label">End Time &nbsp;<span class=" red">*</span></label>'+
                                            '<input type="text" class="form-control  timepickeronly actEnd" onkeydown="return false">' +
                                        '</div>' +
                                    '</div>' +
                                '</div>');
        daterangepicker();
		timepickers();
		$("#txttotalfacilities").text("0.00");
        $("#tblFacilities").html("");
		$("#txttotalsound").text("0.00");
        $("#tblSound").html("");
		$("#tblManpower").html("");
		$("#txttotalmanpower").text("0.00");
		$("#tblOrganizer").html("");
		$("#tblPromotional").html("");
		$("#bodyrequirements").html("");
		$("#txteoveralltotal").text("0.00");
		$("#txtunitrent").text("");
		$("#txtunitdays").text("");
		$("#txttotalunitsrent").text("0.00");
		$("#eventsunitinformation").html("");

	}


	function fncLoadUnitevents(InquiryID,proposalNum){
        var UnitIDs = "";
        $.ajax({
            type: 'POST',
            url: 'global_events/class.php',
            data: 'InquiryID=' + InquiryID  + '&proposalNum=' + proposalNum + '&form=fncLoadUnitevents',
            success: function(data){
                var arr = data.split("|");
                $("#eventsunitinformation").html(arr[0]);
                // $("#txtNDTMonthlyRent").val(arr[1]);
                /*$("#txtNDTMonthlyRentOrig").val(arr[1]);*/
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
                /*fncgetPaymentSchedule();*/
                loadtotalamountunits(InquiryID,proposalNum);
            }
        })
    }

    function loadtotalamountunits(InquiryID,proposalNum){
    	$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'InquiryID=' + InquiryID + '&proposalNum=' + proposalNum + '&form=loadtotalamountunits',
			success: function(data) {
				var arr = data.split("|");
				$("#txtunitrent").text(arr[0]);
				$("#txtunitdays").text(arr[1]);
				$("#txttotalunitsrent").text(arr[2]);
				overalltotalsum();
			}
		})
    }



    function getheaderprintx(mallid,classN,condition){
			var cond = JSON.parse( condition ).join('&');
			var toprint = "";
			$.ajax({
	            type: 'POST',
	            url: 'global_events/class.php',
	            data: 'mallID=' + mallid + '&form=getheaderprint',
	            success:function(data){
	            	// alert(data);
	                //$("#printable_divtemplate").html(data);
	                // toprint = $("#printable_div_header_container").html();
	           
	            }, complete: function(){
	            	var eventsid = $("#lblSNo").text();
	            	$.ajax({
	            		type: 'POST',
			            url: 'global_events/class.php',
			            data: cond + '&eventsid=' + eventsid + '&form='+classN,
			            success:function(data){
			            	 $("#printable_div_content").html(data);
			                toprint = $("#printable_div").html();	
			            	var myheight = $(window).height()-40;
			                var mywidth = $(window).width()-40;
			                var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
			                popupWin.document.open();
			                popupWin.document.write("<html><head><link rel='stylesheet' href='assets/css/bootstrap.min.css' /><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
			                popupWin.document.close();
			            }
	                })
	            }
	        })
		}


		function fncLoadRemarksevents(InquiryID){
			var lblSNo = $("#lblSNo").text();
	        $.ajax({
	            type: 'POST',
	            url: 'global_events/class.php',
	            data: 'InquiryID=' + InquiryID + '&eventsid=' + lblSNo + '&form=fncLoadRemarksevents',
	            success: function(data){
	                $("#eventInqRemarks").html(data);
	            }
	        })
	    }

	    function addnewremarks_events(InquiryID){
	        $("#modal_new_remarks_events").modal("show");
	        $("#txt_remarksvents").val("");
	        $("#txtremIDevents").val("");
	        $("#btnsavenoweventsremarks").attr("onclick", "savenewremark_events(\""+ InquiryID +"\")");
	    }


		function savenewremark_events(InquiryID){
	        var remarks = $("#txt_remarksvents").val();
	        var txtremIDevents = $("#txtremIDevents").val()
	        var lblSNo = $("#lblSNo").text();
	        if(remarks != "" && !remarks.match(/^\s*$/)){
	            $.ajax({
	                type: 'POST',
	                url: 'mainclass.php',
	                data: 'inqID=' + InquiryID + '&remID=' + txtremIDevents + '&remarks=' + remarks + '&sourceid='  + lblSNo + '&xsource=events&form=savenewremark',
	                success: function(data){
	                    if(data.trim() == 1){
	                        setTimeout(function(){
	                            showmodal("alert", "Successfully added new remarks.", "fncLoadRemarksevents", InquiryID+"|", "", null, "0");
	                        }, 500)
	                    }else if(data.trim() == 2){
	                        setTimeout(function(){
	                            showmodal("alert", "Successfully updated remarks.", "fncLoadRemarksevents", InquiryID+"|", "", null, "0");
	                        }, 500)
	                    }else{
	                        setTimeout(function(){
	                            showmodal("alert", "An error occured.", "", null, "", null, "1");
	                        }, 500)
	                    }
	                    $("#txt_remarksvents").attr("style", "height: 100px;margin-bottom: 10px;border-color:#D5D5D5;");
	                    $("#modal_new_remarks_events").modal("hide");
	                }
	            })       
	        }else{
	            setTimeout(function(){
	                showmodal("alert", "Please enter remarks first.", "makefocus", null, "", null, "1");
	            }, 500)
	            $("#txt_remarksvents").attr("style", "height: 100px;margin-bottom: 10px;border-color:#f2a696;");
	        } 
	    }

	 function edittranremarks_events(remID, inqID){
	 	$("#btnsavenoweventsremarks").attr("onclick", "savenewremark_events(\""+ inqID +"\")");
        $("#txtremIDevents").val(remID);
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'remID=' + remID + '&form=edittranremarks',
            success: function(data){
                $("#txt_remarksvents").val(data);
                $("#modal_new_remarks_events").modal("show");
            }
        })
    }



    function deletetranremarks_events(remID, inqID){
        setTimeout(function(){
            showmodal("confirm", "Are you sure you want to delete this remarks? Click \"OK\" to proceed.", "proceed_deletetranremarks_events", remID+"|"+inqID+"|", "", null, "0");
        }, 500)
    }
    
    function proceed_deletetranremarks_events(remID, inqID){
        $.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'remID='+remID+'&form=deletetranremarks',
            success: function(data){
                if(data == 1){
                    setTimeout(function(){
                        showmodal("alert", "Successfully Deleted.", "fncLoadRemarksevents", inqID+"|", "", null, "0");
                    }, 500)
                }
            }
        })
    }

    function fncopenmodalnotedby(InquiryID){
    	var eventsid = $("#lblSNo").text();
    	$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'InquiryID=' + InquiryID + '&eventsid=' + eventsid + '&form=getlistofuser',
			success: function(data) {
				var arr = data.split("||");
				$("#txteventsnotedby").html(arr[0]);
				$("#btnsavenownoted").attr("onclick", "updatenotedby(\""+ InquiryID +"\")");
				$(".searchy_select").select2();
	    		$(".select2-selection").css('height','33px');
	    		$("#modalnotedbysetup").modal("show");
			}
		})
    }

    function updatenotedby(InquiryID){
    	var eventsid = $("#lblSNo").text();
    	var userid = $("#txteventsnotedby").val();
    	$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'InquiryID=' + InquiryID + '&userid=' + userid +  '&eventsid=' + eventsid  + '&form=updatenotedby',
			success: function(data) {
				if(data==''){
					setTimeout(function(){
						$("#modalnotedbysetup").modal('hide');
                    	showmodal("alert", "Noted by successfully Saved.", "", "", "", null, "0");
                	}, 500);
				}else{
					setTimeout(function(){
                    	showmodal("alert", "Something Went Wrong."+data, "", "", "", null, "0");
            		}, 500);
				}
				
			}
		})
    }


	 $('#frmuploadevents').on('submit', function(e){
			 e.preventDefault();             
	          $.ajax(
	          { 
	            url: 'global_events/uploadattach.php',
	            type: 'POST',
	            data: new FormData(this),
	            contentType: false,
	            processData: false,
	            async:false,
	            success: function(data)
	            {
	                window.location.reload();
	            }
	          });  
	});

	function checkifhasalreadyevents(InquiryID){
    	$.ajax ({
			type: 'POST',
			url: 'global_events/class.php',
			data: 'InquiryID=' + InquiryID  + '&form=checkifhasalreadyevents',
			success: function(data) {
				var arr = data.split("|");
				if(arr[0]=="1"){
					$("#accordeventremarks").show();
					$(".willhide").show();
					formdisplayevents(InquiryID,arr[1],1);
				}
				
			}
		})
	}

   
</script>

