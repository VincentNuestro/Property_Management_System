<script type="text/javascript">
	$(function(){
		$("#txtsearchHouseRules").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageHouseRules").val("1");
				showmainHouseRules(); 
			}else if ( x == '8' ){
				if($('#txtsearchHouseRules').val() == ""){
					$("#txtPageHouseRules").val("1");
					showmainHouseRules();
				}
			}
		});

		$(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash-houserule').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#HouseruleSortType").val("ASC");
						$("#HouseruleSortBy").val(this.id);
						showmainHouseRules();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#HouseruleSortType").val("DESC");
						$("#HouseruleSortBy").val(this.id);
						showmainHouseRules();
					}else if($(this).hasClass("fa-sort")){
						// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#HouseruleSortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#HouseruleSortType").val("DESC");
							$("#HouseruleSortBy").val(this.id);
							showmainHouseRules();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#HouseruleSortType").val("ASC");
							$("#HouseruleSortBy").val(this.id);
							showmainHouseRules();
						}
					}
				});
			// });
			});

		chkwithVatHR();
		allownumbers();
		ifFineChanged();
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

	function showmainHouseRules(){
		var HouseruleSortBy = $('#HouseruleSortBy').val();
		var HouseruleSortType = $('#HouseruleSortType').val();
		var page = $("#txtPageHouseRules").val();
		var key = $("#txtsearchHouseRules").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_HouseRules/class.php',
			data: 'page=' + page + '&key=' + key + '&HouseruleSortBy=' + HouseruleSortBy + '&HouseruleSortType=' + HouseruleSortType + '&form=showmainHouseRules',
		success:function(data){
				if(data == ''){
					$("#tblHouseRules").html("<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblHouseRules").html(data);
				}
			}, complete: function(){
				HouseRulesCatSelected();
				loadEntriesHouseRules();
				loadPageHouseRules();
			}
		})
	}

	function loadEntriesHouseRules(){
		var page = $("#txtPageHouseRules").val();
		var key = $("#txtsearchHouseRules").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_HouseRules/class.php',
			data: 'key=' + key + '&page=' + page + '&form=loadEntriesHouseRules',
			success: function(data){
				$("#txtEntriesHouseRules").text(data);
			}
		});
	}

	function loadPageHouseRules(){
		var page = $("#txtPageHouseRules").val();
		var key = $("#txtsearchHouseRules").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_HouseRules/class.php',
			data: 'key=' + key + '&page=' + page + '&form=loadPageHouseRules',
			success: function(data){
				$("#ulPageHouseRules").html(data);
			}
		});
	}

	function fncPageHouseRules(page, pagenums){
		$(".pgnumHouseRules").removeClass("active");
		$("#pgHouseRules" + pagenums).addClass("active");
		$("#txtPageHouseRules").val(page);
		showmainHouseRules();
	}

	function HouseRulesCatSelected(){
		$("#tblHouseRules tr").each(function(){
			$(this).click(function(){
				$("#tblHouseRules tr").removeClass("selected");
				$(this).addClass("selected");
				selectedHouseRules(this.id);
			})
		})
	}

	function selectedHouseRules(id){
		$("#hiddenequipcatid").val(id);
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_HouseRules/class.php',
			data: 'id=' + id + '&form=selectedHouseRules',
			success: function(data) {
				var arr = data.split("|");
				$("#txtHouseRulesCode").val(arr[0]);
				$("#txtHouseRulesViolation").val(arr[1]);
				$("#txtHouseRules1stoffense").val(arr[2]);
				$("#txtHouseRules1stfine").val(arr[3]);
				if ( arr[4] == 1 ) {
					$("#1stWV").attr("checked", "checked");
				}
				
				$("#txtHouseRules1stVat").val(arr[5]);
				$("#txtHouseRules2ndoffense").val(arr[6]);
				$("#txtHouseRules2ndfine").val(arr[7]);
				if ( arr[8] == 1 ) {
					$("#2ndWV").attr("checked","checked");
				}
				
				$("#txtHouseRules2ndVat").val(arr[9]);
				$("#txtHouseRules3rdoffense").val(arr[10]);
				$("#txtHouseRules3rdfine").val(arr[11]);
				if ( arr[12] == 1 ) {
					$("#3rdWV").attr("checked", "checked");
				}
				
				$("#txtHouseRules3rdVat").val(arr[13]);
				$("#txtHouseRulesSucceeding").val(arr[14]);
				$("#txtHouseRulessucfine").val(arr[15]);
				if ( arr[16] == 1 ) {
					$("#SucWV").attr("checked", "checked");
				}
				$("#txtHouseRulesSucVat").val(arr[17]);
				$("#hiddenequipcatid").val(arr[18]);
			}
		})
	}

	function clickAddHouseRulesCat(){
		$("#tblHouseRules tr").unbind("click");
		$("#tblHouseRules tr").removeClass("selected");
		$("#buttonsHouseRulesCat").css("display", "none");
		$("#savingbuttonsHouseRulesCat").css("display", "block");
		$(".txtHouseRules").removeAttr("readonly");
		$(".txtHouseRules").val("");
		$(".chkVathr").removeAttr("checked");
		$(".amtvat").val("");
	}

	function cancelbuttonHouseRulesCat(){
		showmainHouseRules();
		$("#buttonsHouseRulesCat").css("display", "block");
		$("#savingbuttonsHouseRulesCat").css("display", "none");
		$("#updatebuttonsHouseRulesCat").css("display", "none");
		$(".txtHouseRules").attr("readonly", "readonly");
		$(".txtHouseRules").val("");
		$(".chkVathr").attr("disabled", "disabled");
		$(".chkVathr").removeAttr("checked");
		$(".amtvat").val("");
	}

	function cancelbuttonHouseRulesCat2(){
		showmainHouseRules();
		$("#buttonsHouseRulesCat").css("display", "block");
		$("#updatebuttonsHouseRulesCat").css("display", "none");
		$("#savingbuttonsHouseRulesCat").css("display", "none");
		$(".txtHouseRules").attr("readonly", "readonly");
		$(".chkVathr").attr("disabled", "disabled");
		$(".chkVathr").removeAttr("checked");
		$(".amtvat").val("");
	}

	function clickUpdateHouseRulesCat(){
		var Code = $("#txtHouseRulesCode").val();
		if(Code == "" ){
			setTimeout(function(){
				showmodal("alert", "Select violation first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/main_HouseRules/class.php',
				data: '&Code=' + Code + '&form=clickUpdateHouseRulesCat',
				success: function (data) {
					if(data == 0){
						$("#tblHouseRules tr").unbind("click");
						$("#buttonsHouseRulesCat").css("display", "none");
						$("#updatebuttonsHouseRulesCat").css("display", "block");
						$(".txtHouseRules").removeAttr("readonly");
						$(".chkVathr").removeAttr("disabled");
					}else{
						$("#tblHouseRules tr").unbind("click");
						$("#buttonsHouseRulesCat").css("display", "none");
						$("#updatebuttonsHouseRulesCat").css("display", "block");
						$(".txtHouseRules").removeAttr("readonly");
						$("#txtHouseRulesCode").attr("readonly", "readonly");
						$(".chkVathr").removeAttr("disabled");
					}
				}
			})
		}
	}

	// var saveHouseRule = 0; // JUST ADDED THIS TO AVOID MULTIPLE SAVING IF THE BUTTON WAS CLICKED MULTIPLE TIMES
	function saveHouseRules(){
		var Code = $("#txtHouseRulesCode").val();
		var Violation = $("#txtHouseRulesViolation").val();
		var offense1 = $("#txtHouseRules1stoffense").val();
		var offense2 = $("#txtHouseRules2ndoffense").val();
		var offense3 = $("#txtHouseRules3rdoffense").val();
		var Succeeding = $("#txtHouseRulesSucceeding").val();

		var Fine1 = $("#txtHouseRules1stfine").val();
		var Fine2 = $("#txtHouseRules2ndfine").val();
		var Fine3 = $("#txtHouseRules3rdfine").val();
		var Fine4 = $("#txtHouseRulessucfine").val();

		var vatopt1 = 0;
		if ( $("#1stWV").is(":checked") ) {
			vatopt1 = 1;
		}
		var vatamt1 = $("#txtHouseRules1stVat").val();

		var vatopt2 = 0;
		if ( $("#2ndWV").is(":checked") ) {
			vatopt2 = 1;
		}
		var vatamt2 = $("#txtHouseRules2ndVat").val();

		var vatopt3 = 0;
		if ( $("#3rdWV").is(":checked") ) {
			vatopt3 = 1;
		}
		var vatamt3 = $("#txtHouseRules3rdVat").val();

		var vatopt4 = 0;
		if ( $("#SucWV").is(":checked") ) {
			vatopt4 = 1;
		}
		var vatamt4 = $("#txtHouseRulesSucVat").val();

		// if ( saveHouseRule = 0 ) {
		// 	saveHouseRule = 1;

			var checkHR = 0; // ADDED FOR THE TRAPPING OF BLANK FIELD
			$(".txtHouseRules").each(function(){
				var eto = $(this);

				if ( eto.val() == "" ) {
					checkHR = 1;
				}
			})

			if ( checkHR != 1) { // CHECKING
				$.ajax ({
					type: 'POST',
					url: 'setup/referentialFiles/main_HouseRules/class.php',
					data: '&Code=' + Code + '&Violation=' + Violation + '&offense1=' + offense1 + '&offense2=' + offense2 + '&offense3=' + offense3 + '&Succeeding=' + Succeeding + '&Fine1=' + Fine1 + '&Fine2=' + Fine2 + '&Fine3=' + Fine3 + '&Fine4=' + Fine4 + '&vatopt1=' + vatopt1 + '&vatamt1=' + vatamt1 + '&vatopt2=' + vatopt2 + '&vatamt2=' + vatamt2 + '&vatopt3=' + vatopt3 + '&vatamt3=' + vatamt3 + '&vatopt4=' + vatopt4 + '&vatamt4=' + vatamt4 +'&form=saveHouseRules',
					success: function (data) {
						if(data == 1){
							setTimeout(function(){
								showmodal("alert", "House Rule successfully saved.", "cancelbuttonHouseRulesCat", null, "", null, "0");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", data, "", null, "", null, "1");
							}, 500)
						}
						// saveHouseRule = 0;
					}
				})
			} else {
				setTimeout(function(){
					showmodal("alert", "Please fill all fields", "", null, "", null, "1");
				}, 500)
			}
		// }
	}

	// var updateHRCat = 0;
	function updateHouseRulesCat() {
		// if ( updateHRCat == 0 ) {
		// 	updateHRCat = 1;

			var Code = $("#txtHouseRulesCode").val();
			var Violation = $("#txtHouseRulesViolation").val();
			var offense1 = $("#txtHouseRules1stoffense").val();
			var offense2 = $("#txtHouseRules2ndoffense").val();
			var offense3 = $("#txtHouseRules3rdoffense").val();
			var Succeeding = $("#txtHouseRulesSucceeding").val();
			var id = $("#hiddenequipcatid").val();

			var Fine1 = $("#txtHouseRules1stfine").val();
			var Fine2 = $("#txtHouseRules2ndfine").val();
			var Fine3 = $("#txtHouseRules3rdfine").val();
			var Fine4 = $("#txtHouseRulessucfine").val();

			var vatopt1 = 0;
			if ( $("#1stWV").is(":checked") ) {
				vatopt1 = 1;
			}
			var vatamt1 = $("#txtHouseRules1stVat").val();

			var vatopt2 = 0;
			if ( $("#2ndWV").is(":checked") ) {
				vatopt2 = 1;
			}
			var vatamt2 = $("#txtHouseRules2ndVat").val();

			var vatopt3 = 0;
			if ( $("#3rdWV").is(":checked") ) {
				vatopt3 = 1;
			}
			var vatamt3 = $("#txtHouseRules3rdVat").val();

			var vatopt4 = 0;
			if ( $("#SucWV").is(":checked") ) {
				vatopt4 = 1;
			}
			var vatamt4 = $("#txtHouseRulesSucVat").val();

			var cnt = 0;
			$(".txtHouseRules").each(function(){
				var eto = $(this);

				if ( eto.val() == "" ) {
					cnt = 1;
				}
			})

			if ( cnt != 1 ) {
				$.ajax ({
					type: 'POST',
					url: 'setup/referentialFiles/main_HouseRules/class.php',
					data: '&Code=' + Code + '&Violation=' + Violation + '&offense1=' + offense1 + '&offense2=' + offense2 + '&offense3=' + offense3 + '&Succeeding=' + Succeeding + '&Fine1=' + Fine1 + '&Fine2=' + Fine2 + '&Fine3=' + Fine3 + '&Fine4=' + Fine4 + Fine4 + '&vatopt1=' + vatopt1 + '&vatamt1=' + vatamt1 + '&vatopt2=' + vatopt2 + '&vatamt2=' + vatamt2 + '&vatopt3=' + vatopt3 + '&vatamt3=' + vatamt3 + '&vatopt4=' + vatopt4 + '&vatamt4=' + vatamt4 + '&id=' + id + '&form=updateHouseRulesCat',
					success: function(data){
						if(data == 1){
							setTimeout(function(){
								showmodal("alert", "House Rule successfully updated.", "cancelbuttonHouseRulesCat2", null, "", null, "0");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", data, "", null, "", null, "1");
							}, 500)
						}
						// updateHRCat = 0;
					}
				})
			}else{
				setTimeout(function(){
					showmodal("alert", "Please fill all fields", "", null, "", null, "1");
				}, 500)
			}
		// }
	}

	function clickDeleteHouseRulesCat() {
		var Code = $("#txtHouseRulesCode").val();
		var Violation = $("#txtHouseRulesViolation").val();
		
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_HouseRules/class.php',
			data: '&Code=' + Code + '&form=clickUpdateHouseRulesCat',
			success: function (data) {
				if(data == 0){
					if(Code == ""){
						setTimeout(function(){
							showmodal("alert", "Select Violation first", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("confirm", "Are you sure you want to delete " + Violation, "clickDeleteHouseRulesCat2", null, "", null, "0");
						}, 500)	
					}
				}else{
					setTimeout(function(){
						showmodal("alert", "Referential cannot be deleted as the system has records that needs it.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function clickDeleteHouseRulesCat2(){
		var Code = $("#txtHouseRulesCode").val();
		var Violation = $("#txtHouseRulesViolation").val();
		var id = $("#hiddenequipcatid").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_HouseRules/class.php',
			data: 'id=' + id + '&form=clickDeleteHouseRulesCat',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", Violation + " has been deleted.", "showmainHouseRules", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidateHouseRules(){
		var key = $('#txtsearchHouseRules').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_HouseRules/class.php',
			data: 'key=' + key + '&form=AutoConsolidateHouseRules',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of house rules successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of house rules.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function chkwithVatHR() {
		$(".chkVathr").each(function(){
			var eto = $(this);
			var idneto = eto.prop("id");
			eto.click(function(){
				if ( eto.is(":checked") ) {
					var amt = $("."+idneto+"_amt").val();

					if (( amt == "") || ( amt == 0 ) ) {
						showmodal("alert", "Please enter fine amount first.", "", null, "", null, "1");
						eto.removeAttr("checked", "checked");
					} else {
						var num = amt.replace(",", "");

						var vat = parseFloat(num) * 0.12;

						$("."+idneto+"chk").val(maglagayngComa(vat));
					}

				} else {
					$("."+idneto+"chk").val("0.00");
				}
			})
		})
	}

	function ifFineChanged() {
		$(".txthrfine ").each(function(){
			var eto = $(this);

			eto.blur(function(){
				var yungAmt = eto.val();
				var teka = eto.attr('class');
				var tekaulit = teka.split(" ");
				var etona = tekaulit[4];
				var etonanga = etona.split("_");

				if ( ( eto.val() == "" ) || ( eto.val() < 1 ) ) {
					$("#"+etonanga[0]).removeAttr("checked","checked");
					$("."+etonanga[0]+"chk").val("0.00");
				} else {
					if ( $("#"+etonanga[0]).is(":checked") ) {
						var num = eto.val().replace(",", "");

						var vat = parseFloat(num) * 0.12;

						$("."+etonanga[0]+"chk").val(maglagayngComa(vat));
					}
				}

				setTimeout(function(){
					eto.val(maglagayngComa(yungAmt));
				}, 300)
			})
		})
	}

	function maglagayngComa(num) {
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_HouseRules/class.php',
			async: false,
			data: 'num=' + num + '&form=maglagayngComa',
			success: function (data) {
				num = data;
			}
		})

		return num;
	}
</script>