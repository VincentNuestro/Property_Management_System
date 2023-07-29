<script type="text/javascript">
	$(function(){
		$(".fixTable").tableHeadFixer();
		$(".numberlang").each(function() {
			$(this).keypress(function(event) {
				if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57 || event.which == 44 )) {
					event.preventDefault();
				}
			}); 
		});
		$("#txtSearcMeter").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtMeterListPage").val("1");
				tblShowMeterList(); 
			}else if ( x == '8' ){
				if($('#txtSearcMeter').val() == ""){
					$("#txtMeterListPage").val("1");
					tblShowMeterList();
				}
			}
		});
		$("#txtLastReadSearchTenant").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtLastReadTenantListPage").val("1");
				fncTenantLastReading(); 
			}else if ( x == '8' ){
				if($('#txtLastReadSearchTenant').val() == ""){
					$("#txtLastReadTenantListPage").val("1");
					fncTenantLastReading();
				}
			}
		});
		$("#txtSearchHistory").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				fncViewAssignedTenantHistory(); 
			}else if ( x == '8' ){
				if($('#txtSearchHistory').val() == ""){
					fncViewAssignedTenantHistory();
				}
			}
		});
		$("#txtMeterListPage").val("1");
		tblShowMeterList();
	})

	function tblShowMeterList(){
		var page = $("#txtMeterListPage").val();
		var key = $("#txtSearcMeter").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'page=' + page + '&key=' + key + '&form=tblShowMeterList',
			beforeSend: function(){
				$('#indexloadingscreen').addClass('myspinner');
			},	
			success: function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				if(data != ""){
					$("#tbodyMeterList").html(data);
				}else{
					$("#tbodyMeterList").html("<tr><td colspan='7' style='text-align: center;'>No Data Found...</td></tr>");
				}
				fncMeterListEntries();
				fncMeterListPage();
			}
		})
	}

	function fncMeterListEntries(){
		var page = $("#txtMeterListPage").val();
		var key = $("#txtSearcMeter").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncMeterListEntries',
			success: function(data){
				$("#txtMeterListEntries").text(data);
			}
		});
	}

	function fncMeterListPage(){
		var page = $("#txtMeterListPage").val();
		var key = $("#txtSearcMeter").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncMeterListPage',
			success: function(data){
				$("#txtMeterListPagination").html(data);
			}
		});
	}

	function MeterListPagination(PageMeterList, PageNumMeterList){
		$(".pgNumMeterList").removeClass("active");
		$("#pgMeterList" + PageNumMeterList).addClass("active");
		$("#txtMeterListPage").val(PageMeterList);
		tblShowMeterList();
	}

	function loadMeterFilter(module){
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
				for(var i=0; i<=arr3.length-1; i++){
					$('input:checkbox[id="filter_'+arr3[i]+'"][value="'+arr3[i]+'"]').attr('checked', 'checked');
				}
			}
		})
	}

	function saveMeterFilter(){
		var module = "MeterManagement";
		var checked = "";
		$('input:checkbox[name="form-field-MeterSearch"]').each(function(){
			if($(this).is(":checked")){
				var value = $(this).attr("value");
				checked += value + "|";
			}
		})
		var checked2 = "";
		$('input:checkbox[name="form-field-MeterSearch"]').each(function(){
				var value2 = $(this).attr("value");
				checked2 += value2 + "|";
		})
		var checked3 = "";
		$('input:checkbox[name="form-field-MeterStat"]').each(function(){
			if($(this).is(":checked")){
				var value3 = $(this).attr("value");
				checked3 += value3 + "|";
			}
		})        
		var xcheck = "";
		var Date1 = "";
		var Date2 = "";
		$.ajax({
			type: 'POST',
			url: 'filter/class.php',
			data: 'module=' + module + '&checked=' + checked + '&checked2=' + checked2 + '&checked3=' + checked3 + '&xcheck=' + xcheck + '&Date1=' + Date1 + '&Date2=' + Date2 + '&form=saveFilters',
			success: function(data){
				tblShowMeterList();
				$("#LINK_MeterManagement_filter").click();
			}
		})
	}

	function fncAddNewMeter(){
		fncSubMeterClear(); // Added By Ronald
		$("#mdlAddNewMeter").modal("show");
		$("#hdrAddNewMeter").text("New Meter");
		$("#btnfncSaveMeterInfo").attr("onclick", "fncSaveNewMeter('Add', '')");
	}
	// START Added By Ronald 2019-01-03
	function execDelSubMeter(id){
		$("#"+id).remove();
	}

	function delsubmeter(id){
		showmodal("confirm", "Do you want to remove this sub meter?", "execDelSubMeter", id+"|" , "", null, "1");
	}

	function addToTableRon(){
		var count = 0;
		$(".refSubMeterRequired").each(function(){
			if($(this).val() == ""){
				count++;
			}
		});
		var subM = 0;
		$('#tblsubMeterList').find('tr').each(function(){
			subM++;
		});


		if( count == 0 ){
			$('#tblsubMeterList').append( "<tr id='subM"+subM+"' ><td>"+$('#txtSubMeterID').val()+"</td><td>"+$('#txtSubMeterusage').val()+"</td><td>"+$('#txtSubMeterMulti').val()+"</td><td><div style='z-index: 0;'><button class='btn btn-sm btn-danger btn-round' title='Delete Meter' style='z-index: 0;margin: 2px;' onclick='delsubmeter(\"subM"+subM+"\");' ><img src='assets/images/remove.png' style='width: 100%; height: auto;'></button></div></td></tr>" );
			$('#txtSubMeterID').val('');
			$('#txtSubMeterusage').val('');
			$('#txtSubMeterMulti').val('');
		} else {
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500);
		}
	}

	$('#btnfncSaveSubMeterInfo').click(function(){

		if( $('#txtMeterID').val() != '' ||  $('#txtMeterType').val() != '' ){

			$.ajax({
				type: 'POST',
				url: 'maintenance/metermanagement/class.php',
				data: 'MeterID=' + $('#txtSubMeterID').val() + '&MeterType=' + $('#txtMeterType').val() + '&form=checkMeterIDifExist',
				success: function(data){
					if(data == 0){
						if( $('#txtSubMeterID').val() != $('#txtMeterID').val() ){
							var existInTable = 0;
							$('#tblsubMeterList').find('tr').each(function(){
								if( $(this).find('td').eq(0).text() == $('#txtSubMeterID').val() ){
									existInTable = 1;
								}
							});
							if( existInTable == 0 ){
								addToTableRon();
							} else {
								setTimeout(function(){
									showmodal("alert", "This Sub Meter ID is already exist in table.", "", null, "", null, "1");
								}, 500);
							}
						} else {
							setTimeout(function(){
								showmodal("alert", "Meter ID and Sub Meter ID are same.", "", null, "", null, "1");
							}, 500);
						}
					} else {
						setTimeout(function(){
							showmodal("alert", "Sub Meter ID already exist!", "", null, "", null, "1");
						}, 500);
					}
				}
			})

			

		} else {
			setTimeout(function(){
				showmodal("alert", "MeterID and Meter Type are both required, Please fill those fields.", "", null, "", null, "1");
			}, 500);
		}

		
	});

	$('#withSubM').click(function(){
		fncwithsubmeter();
	});

	function fncwithsubmeter(){
		if( $('#withSubM').is(':checked') ){
			$('#subMCorner input[type=text]').prop('disabled',false);
			$('#subMCorner button').prop('disabled',false);
			$('#subMCorner').css('cursor','default');
		} else {
			$('#subMCorner input[type=text]').prop('disabled',true);
			$('#subMCorner button').prop('disabled',true);
			$('#subMCorner').css('cursor','not-allowed');
		}
	}

	function fncSubMeterClear(){

		$('#txtSubMeterID').val('');
		$('#txtSubMeterusage').val('');
		$('#txtSubMeterMulti').val('');
		$('#tblsubMeterList').html('');
		$('#withSubM').prop('checked',false);
		fncwithsubmeter();

	}

	function fncEditSubmeter(MeterType, id){

		var MeterID = $('#txteditsubMeterID').val();
		var MeterUsage = $('#txteditsubMeterUsage').val();
		var Multiplier = $('#txteditsubMeterMultiplier').val();

		if( MeterID != '' || MeterUsage != '' || Multiplier != '' ){
			if(Multiplier >= 1){

				$.ajax({
					type: 'POST',
					url: 'maintenance/metermanagement/class.php',
					data: 'MeterUsage=' + MeterUsage + '&MeterID=' + MeterID + '&Multiplier=' + Multiplier + '&MeterType=' + MeterType + '&id=' + id + '&form=fncSaveEditsubMeter',
					success: function(data){
						if(data == 1){
							setTimeout(function(){
								showmodal("alert", "Sub meter successfully saved.", "fncAddNewMeterX", null, "", null, "0");
								$("#mdleditsubmeter").modal("hide");
							}, 500)
						}else if(data == 3){	
							setTimeout(function(){
								showmodal("alert", "Sub Meter ID already exist!", "", null, "", null, "1");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", "Failed to save sub meter.", "", null, "", null, "1");
							}, 500)
						}
					}
				})
			}else{
				setTimeout(function(){
					showmodal("alert", "Multiplier cannot be zero.", "", null, "", null, "1");
				}, 500)
			}
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}
	// END Added By Ronald 2019-01-03

	// MODIFIED BY PETER (ADDED FEB 14, 2019)
	function fncSaveNewMeter(Action, id){
		// START Added By Ronald 2019-01-03
		var subMeters;
		var withSubM = 0;
		if( $('#withSubM').is(':checked') ){

			$('#tblsubMeterList').find('tr').each(function(){
				subMeters += '|##|'+$(this).find('td').eq(0).text()+'|#|'+$(this).find('td').eq(1).text()+'|#|'+$(this).find('td').eq(2).text();
			});

			withSubM = 1;

		}
		// END Added By Ronald 2019-01-03
		var MeterType = $("#txtMeterType").val();
		var MeterUsage = $("#txtMeterUsage").val();
		var MeterID = $("#txtMeterID").val();
		var Multiplier = $("#txtMeterMultiplier").val();
		var count = 0;
		$(".refMeterRequired").each(function(){
			if($(this).val() == ""){
				count++;
			}
		})
		if(count == 0){
			if(Multiplier >= 1){
				$.ajax({
					type: 'POST',
					url: 'maintenance/metermanagement/class.php',
					data: 'MeterType=' + MeterType + '&MeterUsage=' + MeterUsage + '&MeterID=' + MeterID + '&Multiplier=' + Multiplier + '&Action=' + Action + '&id=' + id + '&subMeters=' + subMeters + '&withSubM=' + withSubM + '&form=fncSaveNewMeter',
					success: function(data){
						if(data == 1){
							setTimeout(function(){
								showmodal("alert", "New meter successfully saved.", "fncAddNewMeterX", null, "", null, "0");
								fncSubMeterClear();
								$(".refMeterRequired").val("");
							}, 500)
						}else if(data == 3){	
							setTimeout(function(){
								showmodal("alert", "Meter ID already exist!", "", null, "", null, "1");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", "Failed to save new meter.", "", null, "", null, "1");
							}, 500)
						}
					}
				})
			}else{
				setTimeout(function(){
					showmodal("alert", "Multiplier cannot be zero.", "", null, "", null, "1");
				}, 500)
			}
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncAddNewMeterX(){
		$("#mdlAddNewMeter").modal("hide");
		$("#txtMeterType").val("");
		$("#txtMeterUsage").val("");
		$("#txtMeterID").val("");
		$("#txtMeterMultiplier").val("");
		tblShowMeterList();
	}
	// Modified by Ronald
	function fncEditMeterInfo(MeterID, MeterType, Multiplier, id, CurrentMeterUsage,withSubM,parentmeterid){
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'MeterID=' + MeterID + '&MeterType=' + MeterType + '&form=viewSubMeter',
			success: function(data){
				fncSubMeterClear();
				if( withSubM == 1 ){
					$('#withSubM').prop('checked',true);
					fncwithsubmeter();
				}
				$("#tblsubMeterList").html(data);
			}
		});
		// $("#mdlAddNewMeter").modal("show");
		// $("#txtMeterType").val(MeterType);
		// $("#txtMeterID").val(MeterID);
		// $("#txtMeterMultiplier").val(Multiplier);
		// $("#txtMeterUsage").val(CurrentMeterUsage);
		// $("#hdrAddNewMeter").text("Edit Meter");
		// $("#btnfncSaveMeterInfo").attr("onclick", "fncSaveNewMeter('Edit', \""+ id +"\")");
		if( parentmeterid == '' ){
			$("#mdlAddNewMeter").modal("show");
			$("#txtMeterType").val(MeterType);
			$("#txtMeterID").val(MeterID);
			$("#txtMeterMultiplier").val(Multiplier);
			$("#txtMeterUsage").val(CurrentMeterUsage);
			$("#hdrAddNewMeter").text("Edit Meter");
			$("#btnfncSaveMeterInfo").attr("onclick", "fncSaveNewMeter('Edit', \""+ id +"\")");
		} else {
			$("#mdleditsubmeter").modal("show");
			// $("#txtMeterType").val(MeterType);
			$("#txteditsubMeterID").val(MeterID);
			$("#txteditsubMeterMultiplier").val(Multiplier);
			$("#txteditsubMeterUsage").val(CurrentMeterUsage);
			// $("#hdrAddNewMeter").text("Edit Meter");
			$("#btnfncSaveEditsubMeterInfo").attr("onclick", "fncEditSubmeter(\""+ MeterType +"\", \""+ id +"\")");
		}
	}
	// END Modified by Ronald

	function fncAssignTenant(MeterID, MeterType, TenantID, CurrentMeterUsage){
		$("#mdlBrowseTenant").modal("show");
		$("#txtMeterTenantListPage").val("1");
		tblMeterTenantList(MeterID, MeterType, TenantID, CurrentMeterUsage);
		$("#txtMeterSearchTenant").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtMeterTenantListPage").val("1");
				tblMeterTenantList(MeterID, MeterType, TenantID, CurrentMeterUsage);
			}else if ( x == '8' ){
				if($('#txtMeterSearchTenant').val() == ""){
					$("#txtMeterTenantListPage").val("1");
					tblMeterTenantList(MeterID, MeterType, TenantID, CurrentMeterUsage);
				}
			}
		});
	}

	function tblMeterTenantList(MeterID, MeterType, TenantID, CurrentMeterUsage){
		var page = $("#txtMeterTenantListPage").val();
		var key = $("#txtMeterSearchTenant").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'page=' + page + '&MeterID=' + MeterID + '&MeterType=' + MeterType + '&key=' + key + '&TenantID=' + TenantID + '&CurrentMeterUsage=' + CurrentMeterUsage + '&form=tblMeterTenantList',
			beforeSend: function(){
				$("#preLoadmdlBrowseTenant").addClass("myspinner");
			},
			success: function(data){
				$("#preLoadmdlBrowseTenant").removeClass("myspinner");
				if(data != ""){
					$("#tblMeterTenantList").html(data);
					$("#tblMeterTenantList tr").each(function(){
						$(this).click(function(){
							$("#tblMeterTenantList tr").removeClass("selected");
							if($(this).hasClass("selected")){
								$(this).removeClass("selected");
							}else{
								$(this).addClass("selected");
							}
						})
					})
				}else{
					$("#tblMeterTenantList").html("<tr><td colspan='5' style='text-align: center;'>No Data Found...</td></tr>");
				}
				fncMeterTenantListEntries(TenantID);
				fncMeterTenantListPagination(MeterID, MeterType, TenantID);
			}
		})
	}

	function fncMeterTenantListEntries(TenantID){
		var page = $("#txtMeterTenantListPage").val();
		var key = $("#txtMeterSearchTenant").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'key=' + key + '&page=' + page + '&TenantID=' + TenantID + '&form=fncMeterTenantListEntries',
			success: function(data){
				$("#txtMeterTenantListEntries").text(data);
			}
		});
	}

	function fncMeterTenantListPagination(MeterID, MeterType, TenantID){
		var page = $("#txtMeterTenantListPage").val();
		var key = $("#txtMeterSearchTenant").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: '&MeterID=' + MeterID + '&MeterType=' + MeterType + '&key=' + key + '&page=' + page + '&TenantID=' + TenantID + '&form=fncMeterTenantListPagination',
			success: function(data){
				$("#txtMeterTenantListPagination").html(data);
			}
		});
	}

	function MeterTenantListPagination(pageTenantList, pageNumTenantList, MeterID, MeterType, TenantID){
		$(".pgNumTenantList").removeClass("active");
		$("#pgTenantList" + pageNumTenantList).addClass("active");
		$("#txtMeterTenantListPage").val(pageTenantList);
		tblMeterTenantList(MeterID, MeterType, TenantID);
	}

	function fncAssigningConfirmation(MeterID, MeterType, Tenant, TenantID, CurrentMeterUsage){
		showmodal("confirm", "You are about to change the assigned tenant for "+ MeterID +", by doing so you are required to input the latest reading of this meter. Are you sure you want to proceed?", "fncInputLatestReading", MeterID+"|"+MeterType+"|"+TenantID+"|"+CurrentMeterUsage+"|", "", null, "1");
	}

	function fncInputLatestReading(MeterID, MeterType, TenantID, CurrentMeterUsage){
		$("#mdlInputLastReading").modal("show");
		$("#txtCurrentMeterReading").val(CurrentMeterUsage);
		$("#btnCurrentMeterReading").attr("onclick", "fncAssigningConfirmed(\""+ MeterID +"\", \""+ MeterType +"\", \""+ TenantID +"\")");
	}

	function fncAssigningConfirmed(MeterID, MeterType, TenantID){
		var CurrentMeter = $("#txtCurrentMeterReading").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'CurrentMeter=' + CurrentMeter + '&MeterID=' + MeterID + '&MeterType=' + MeterType + '&TenantID=' + TenantID + '&form=fncAssigningConfirmed',
			success: function(data){
				if(data == 1){
					tblShowMeterList();
					$("#mdlBrowseTenant").modal("hide");
					$("#mdlInputLastReading").modal("hide");
				}else{
					setTimeout(function(){
						showmodal("alert", "Latest meter reading cannot be lower than current meter usage.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function fncDeleteMeter(MeterID){
		showmodal("confirm", "Are you sure you want to delete " + MeterID + "?", "fncDeleteMeter2", MeterID+"|", "", null, "1");
	}

	function fncDeleteMeter2(MeterID){
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'MeterID=' + MeterID + '&form=fncDeleteMeter',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", MeterID + " successfully deleted.", "tblShowMeterList", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to delete " + MeterID + ".", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function fncTenantLastReading(){
		var page = $("#txtLastReadTenantListPage").val();
		var key = $("#txtLastReadSearchTenant").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'page=' + page + '&key=' + key + '&form=fncTenantLastReading',
			beforeSend: function(){
				$("#preLoadmdlTenantLastReading").addClass("myspinner");
			},
			success: function(data){
				$("#preLoadmdlTenantLastReading").removeClass("myspinner");
				if(data != ""){
					$("#tblLastReadTenantList").html(data);
				}else{
					$("#tblLastReadTenantList").html("<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>");
				}
				$(".date-picker").datepicker({
					autoHide: true,
					format: 'mm/dd/yyyy',
					todayHighlight: true
				});
				fncLastReadTenantListEntries();
				fncLastReadTenantListPagination();
			}
		})
	}

	function fncLastReadTenantListEntries(){
		var page = $("#txtLastReadTenantListPage").val();
		var key = $("#txtLastReadSearchTenant").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncLastReadTenantListEntries',
			success: function(data){
				$("#txtLastReadTenantListEntries").text(data);
			}
		});
	}

	function fncLastReadTenantListPagination(){
		var page = $("#txtLastReadTenantListPage").val();
		var key = $("#txtLastReadSearchTenant").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncLastReadTenantListPagination',
			success: function(data){
				$("#txtLastReadTenantListPagination").html(data);
			}
		});
	}

	function LastReadTenantListPagination(pageLastReadTenantList, pageNumLastReadTenantList){
		$(".pgNumLastReadTenantList").removeClass("active");
		$("#pgLastReadTenantList" + pageNumLastReadTenantList).addClass("active");
		$("#txtLastReadTenantListPage").val(pageLastReadTenantList);
		fncTenantLastReading();
	}

	function fncEditLastRead(TenantID){
		$("#btnEdit"+TenantID).css("display", "none");
		$("#btnSave"+TenantID).css("display", "block");
		$("#btnCancel"+TenantID).css("display", "block");
		$("#txtLastReadWater"+TenantID).css("display", "block");
		$("#lblLastReadWater"+TenantID).css("display", "none");
		$("#txtLastReadElectric"+TenantID).css("display", "block");
		$("#lblLastReadElectric"+TenantID).css("display", "none");
		$("#txtLastReadGas"+TenantID).css("display", "block");
		$("#lblLastReadGas"+TenantID).css("display", "none");
	}

	function fncSaveLastRead(TenantID){
		var LastReadWater = $("#txtLastReadWater"+TenantID).val();
		var LastReadElectric = $("#txtLastReadElectric"+TenantID).val();
		var LastReadGas = $("#txtLastReadGas"+TenantID).val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'LastReadWater=' + LastReadWater + '&LastReadElectric=' + LastReadElectric + '&LastReadGas=' + LastReadGas + '&TenantID=' + TenantID + '&form=fncSaveLastRead',
			success: function(data){
				var arr = data.split("|");
				if(arr[0] == 1){
					$("#btnEdit"+TenantID).css("display", "block");
					$("#btnSave"+TenantID).css("display", "none");
					$("#btnCancel"+TenantID).css("display", "none");
					$("#txtLastReadWater"+TenantID).css("display", "none");
					$("#lblLastReadWater"+TenantID).css("display", "block");
					$("#txtLastReadElectric"+TenantID).css("display", "none");
					$("#lblLastReadElectric"+TenantID).css("display", "block");
					$("#txtLastReadGas"+TenantID).css("display", "none");
					$("#lblLastReadGas"+TenantID).css("display", "block");
					$("#lblLastReadWater"+TenantID).text(arr[1]);
					$("#lblLastReadElectric"+TenantID).text(arr[2]);
					$("#lblLastReadGas"+TenantID).text(arr[3]);
				}
			}
		})
	}

	function fncCancelLastRead(TenantID){
		$("#btnEdit"+TenantID).css("display", "block");
		$("#btnSave"+TenantID).css("display", "none");
		$("#btnCancel"+TenantID).css("display", "none");
		$("#txtLastReadWater"+TenantID).css("display", "none");
		$("#lblLastReadWater"+TenantID).css("display", "block");
		$("#txtLastReadElectric"+TenantID).css("display", "none");
		$("#lblLastReadElectric"+TenantID).css("display", "block");
		$("#txtLastReadGas"+TenantID).css("display", "none");
		$("#lblLastReadGas"+TenantID).css("display", "block");
	}

	function ViewAssignedTenantHistory(MeterID, MeterType){
		$("#txtHiddenMeterID").val(MeterID);
		$("#txtHiddenMeterType").val(MeterType);
		$("#mdlMeterHistory").modal("show");
		fncViewAssignedTenantHistory();
	}

	function fncViewAssignedTenantHistory(){
		var key = $("#txtSearchHistory").val();
		var MeterID = $("#txtHiddenMeterID").val();
		var MeterType = $("#txtHiddenMeterType").val();
		var DateFrom = $("#txtDateFromHistory").val();
		var DateTo = $("#txtDateToHistory").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/metermanagement/class.php',
			data: 'key=' + key + '&MeterID=' + MeterID + '&MeterType=' + MeterType + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&form=ViewAssignedTenantHistory',
			success: function(data){
				if(data != ""){
					$("#tblMeterHistory").html(data);
				}else{
					$("#tblMeterHistory").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
				}
			}
		})
	}
</script>