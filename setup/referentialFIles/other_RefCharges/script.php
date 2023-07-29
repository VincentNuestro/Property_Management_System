<script type="text/javascript">
	$(function(){
		$("#txtsearchRefCharges").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageCharges").val("1");
				showRefCharges(); 
			}else if ( x == '8' ){
				if($('#txtsearchRefCharges').val() == ""){
					$("#txtPageCharges").val("1");
					showRefCharges();
				}
			}
		});
		$(".numonly").keydown(function(event) {
            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188) {
            }else{
                if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
                   event.preventDefault(); 
                }   
            }
        });

        $(function(){
			$('.btnsortdash-refcharges').click(function(){
				if($(this).hasClass("fa-sort-up")){
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#RefChargesSortType").val("ASC");
					$("#RefChargesSortBy").val(this.id);
					showRefCharges();
				}
				else if($(this).hasClass("fa-sort-down")){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#RefChargesSortType").val("DESC");
					$("#RefChargesSortBy").val(this.id);
					showRefCharges();
				}else if($(this).hasClass("fa-sort")){
					// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
					if($("#RefChargesSortType").val() == "ASC"){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#RefChargesSortType").val("DESC");
						$("#RefChargesSortBy").val(this.id);
						showRefCharges();
					}else{
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#RefChargesSortType").val("ASC");
						$("#RefChargesSortBy").val(this.id);
						showRefCharges();
					}
				}
			});
		});
	});

	function showRefCharges(){
		var RefChargesSortBy = $('#RefChargesSortBy').val();
		var RefChargesSortType = $('#RefChargesSortType').val();
	    var page = $("#txtPageCharges").val();
		var key = $("#txtsearchRefCharges").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/other_RefCharges/class.php',
			data: 'page=' + page + '&key=' + key + '&RefChargesSortBy=' + RefChargesSortBy`` + '&RefChargesSortType=' + RefChargesSortType + '&form=showRefCharges',
			success: function(data){
				if(data == ''){
					$("#tbodyRefCharges").html("<tr><td colspan='7' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tbodyRefCharges").html(data);
				}
			}, complete: function(){
				RefChargesSelect();
				loadEntriesCharges();
				loadPageCharges();
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
			}
		})
	}

	function loadEntriesCharges(){
	    var page = $("#txtPageCharges").val();
	    var key = $("#txtsearchRefCharges").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/other_RefCharges/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesCharges',
	        success: function(data){
	            $("#txtEntriesCharges").text(data);
	        }
	    });
	}

	function loadPageCharges(){
	    var page = $("#txtPageCharges").val();
	    var key = $("#txtsearchRefCharges").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/other_RefCharges/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageCharges',
	        success: function(data){
	            $("#ulPageCharges").html(data);
	        }
	    });
	}

    function fncPageCharges(page, pagenums){
        $(".pgnumCharges").removeClass("active");
        $("#pgCharges" + pagenums).addClass("active");
        $("#txtPageCharges").val(page);
        showRefCharges();
    }

	function RefChargesSelect(){
		$("#tbodyRefCharges tr").each(function(){
			$(this).click(function(){
				$("#tbodyRefCharges tr").removeClass("selected");
				$(this).addClass("selected");
				SelectedRefCharges(this.id);
			})
		})
	}

	function SelectedRefCharges(id) {
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/other_RefCharges/class.php',
			data: 'id=' + id + '&form=SelectedRefCharges',
			success: function(data) {
				var arr = data.split("|");
				$("#txtChargeCode").val(arr[0]);
				$("#txtChargeDesc").val(arr[1]);
				$("#txtChargesType").val(arr[2]).trigger("change");
				$("#txtChargesRateType").val(arr[3]).trigger("change");
				$("#txtChargesRate").val(arr[4]);
				$("#txtChargesReason").val(arr[5]);
				if(arr[3] == "Other"){
					$("#div_otherReason").css("display", "block");
					$("#div_Rate").css("display", "none");
				}else if(arr[3] == "Occurence"){
					$("#div_otherReason").css("display", "block");
					$("#div_Rate").css("display", "block");
				}else{
					$("#div_otherReason").css("display", "none");
					$("#div_Rate").css("display", "block");
				}
				$(".isDefaultToPro").each(function(){
		            if($(this).attr("id") == arr[6]){ 
		            	$(this).prop("checked", true); 
		            }
		        });
		        $("#HiddenChargesID").val(arr[7]);
			}
		})
	}

	function RateTypeChanged(anoto){
		if(anoto == "Other"){
			$("#div_otherReason").css("display", "block");
			$("#div_Rate").css("display", "none");
		}else if(anoto == "Occurence"){
			$("#div_otherReason").css("display", "block");
			$("#div_Rate").css("display", "block");
		}else{
			$("#div_otherReason").css("display", "none");
			$("#div_Rate").css("display", "block");
		}
	}

	function clickAddNewCharges(){
		$("#tbodyRefCharges tr").unbind("click");
		$("#tbodyRefCharges tr").removeClass("selected");
		$("#buttonsRefCharges").css("display", "none");
		$("#savingbuttonsRefCharges").css("display", "block");
		$(".classCharges").removeAttr("readonly");
		$(".classCharges").val("");
		$(".classCharges2").prop("disabled", false);
		$(".classCharges2").val("");
	}

	function clickCancelNewCharges(){
		showRefCharges();
		$("#buttonsRefCharges").css("display", "block");
		$("#savingbuttonsRefCharges").css("display", "none");
		$(".classCharges").attr("readonly", "readonly");
		$(".classCharges").val("");
		$(".classCharges2").prop("disabled", true);
		$(".classCharges2").val("");
		$("#div_otherReason").css("display", "none");
		$("#div_Rate").css("display", "none");
	}

	function clickCancelNewCharges2(){
		showRefCharges();
		$("#buttonsRefCharges").css("display", "block");
		$("#updatebuttonsRefCharges").css("display", "none");
		$(".classCharges").attr("readonly", "readonly");
		$(".classCharges2").prop("disabled", true);
		$("#div_otherReason").css("display", "none");
		$("#div_Rate").css("display", "none");
	}

	function clickUpdateCharges(){
		var txtChargeCode = $("#txtChargeCode").val();
		if(txtChargeCode == ""){
			setTimeout(function(){
				showmodal("alert", "Select charge first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/other_RefCharges/class.php',
				data: 'txtChargeCode=' + txtChargeCode + '&form=clickUpdateCharges',
				success:function(data){
					if(data == 0){
						$("#tbodyRefCharges tr").unbind("click");
						$("#buttonsRefCharges").css("display", "none");
						$("#updatebuttonsRefCharges").css("display", "block");
						$(".classCharges").removeAttr("readonly");
						$(".classCharges2").prop("disabled", false);
						$("#txtChargeCode").removeAttr("readonly");
					}else{
						$("#tbodyRefCharges tr").unbind("click");
						$("#buttonsRefCharges").css("display", "none");
						$("#updatebuttonsRefCharges").css("display", "block");
						$(".classCharges").removeAttr("readonly");
						$(".classCharges2").prop("disabled", false);
						$("#txtChargeCode").attr("readonly", "readonly");
					}
				}
			})
		}
	}

	function UpdateRefCharges(){
		var count = 0;
		$(".reqRefCharges").each(function(){
			if($(this).val() == ""){
				count++;
			}
		})
		var ChargesID = $("#HiddenChargesID").val();
		var ChargeCode = $("#txtChargeCode").val();
		var ChargeDesc = $("#txtChargeDesc").val();
		var ChargesType = $("#txtChargesType").val();
		var ChargesRateType = $("#txtChargesRateType").val();
		var ChargesRate = $("#txtChargesRate").val();
		var ChargesReason = $("#txtChargesReason").val();
		var isDefault = "";
		$(".isDefaultToPro").each(function(){
			if($(this).is(":checked")){
				isDefault = $(this).attr("id");
			}
		})
		if(ChargesRateType == "Other" && ChargesReason == ""){
			setTimeout(function(){
				showmodal("alert", "Please fill all fields", "", null, "", null, "1");
			}, 500)
		}else{
			if(ChargesRateType == "Occurence" && (ChargesRate == "" || ChargesReason == "")){
				setTimeout(function(){
					showmodal("alert", "Please fill all fields", "", null, "", null, "1");
				}, 500)
			}else{
				$.ajax({
					type: 'POST',
					url: 'setup/referentialFiles/other_RefCharges/class.php',
					data: 'ChargesID=' + ChargesID + '&ChargeCode=' + ChargeCode + '&ChargeDesc=' + ChargeDesc + '&ChargesType=' + ChargesType + '&ChargesRateType=' + ChargesRateType + '&ChargesRate=' + ChargesRate + '&ChargesReason=' + ChargesReason + '&isDefault=' + isDefault + '&form=UpdateRefCharges',
					success:function(data){
						if(data == 1){
							setTimeout(function(){
								showmodal("alert", "Charges type successfully saved.", "clickCancelNewCharges2", null, "", null, "0");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", data, "", null, "", null, "1");
							}, 500)
						}
					}
				})
			}
		}
	}

	function clickDeleteRefCharges(){
		var ChargeCode = $("#txtChargeCode").val();
		var ChargeDesc = $("#txtChargeDesc").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/other_RefCharges/class.php',
			data: 'txtChargeCode=' + ChargeCode + '&form=clickUpdateCharges',
			success:function(data){
				if(data == 0){
					if(ChargeCode == ""){
						setTimeout(function(){
							showmodal("alert", "Select charge first", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("confirm", "Are you sure you want to delete " + ChargeDesc, "clickDeleteRefCharges2", null, "", null, "0");
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

	function clickDeleteRefCharges2(){
		var ChargesID = $("#HiddenChargesID").val();
		var ChargeCode = $("#txtChargeCode").val();
		var ChargeDesc = $("#txtChargeDesc").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/other_RefCharges/class.php',
			data: 'ChargeCode=' + ChargeCode + '&ChargesID=' + ChargesID + '&form=clickDeleteRefCharges',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", ChargeDesc + " has been deleted.", "showRefCharges", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
							showmodal("alert", data, "", null, "", null, "1");
						}, 500)
				}
			}
		})
	}

	function SaveNewRefCharges(){
		var count = 0;
		$(".reqRefCharges").each(function(){
			if($(this).val() == ""){
				count++;
			}
		})
		var ChargeCode = $("#txtChargeCode").val();
		var ChargeDesc = $("#txtChargeDesc").val();
		var ChargesType = $("#txtChargesType").val();
		var ChargesRateType = $("#txtChargesRateType").val();
		var ChargesRate = $("#txtChargesRate").val();
		var ChargesReason = $("#txtChargesReason").val();
		var isDefault = "";
		$(".isDefaultToPro").each(function(){
			if($(this).is(":checked")){
				isDefault = $(this).attr("id");
			}
		})
		if(ChargesRateType == "Other" && ChargesReason == ""){
			setTimeout(function(){
				showmodal("alert", "Please fill all fields", "", null, "", null, "1");
			}, 500)
		}else{
			if(ChargesRateType == "Occurence" && (ChargesRate == "" || ChargesReason == "")){
				setTimeout(function(){
					showmodal("alert", "Please fill all fields", "", null, "", null, "1");
				}, 500)
			}else{
				$.ajax({
					type: 'POST',
					url: 'setup/referentialFiles/other_RefCharges/class.php',
					data: 'ChargeCode=' + ChargeCode + '&ChargeDesc=' + ChargeDesc + '&ChargesType=' + ChargesType + '&ChargesRateType=' + ChargesRateType + '&ChargesRate=' + ChargesRate + '&ChargesReason=' + ChargesReason + '&isDefault=' + isDefault + '&form=SaveNewRefCharges',
					success:function(data){
						if(data == 1){
							setTimeout(function(){
								showmodal("alert", "Charges type successfully saved.", "clickCancelNewCharges", null, "", null, "0");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", data, "", null, "", null, "1");
							}, 500)
						}
					}
				})
			}
		}
	}

	function AutoConsolidateCharges(){
		var key = $('#txtsearchRefCharges').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/other_RefCharges/class.php',
			data: 'key=' + key + '&form=AutoConsolidateCharges',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of charges successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of charges.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>