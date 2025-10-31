<script type="text/javascript">
	$(function(){
		$("#txtsearchPaymentType").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPagePaymentType").val("1");
				displayPaymentType(); 
			}else if ( x == '8' ){
				if($('#txtsearchPaymentType').val() == ""){
					$("#txtPagePaymentType").val("1");
					displayPaymentType();
				}
			}
		});

		$(function(){
			$('.btnsortdash-othpayment').click(function(){
				if($(this).hasClass("fa-sort-up")){
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#othPaymentSortType").val("ASC");
					$("#othPaymentSortBy").val(this.id);
					displayPaymentType();
				}
				else if($(this).hasClass("fa-sort-down")){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#othPaymentSortType").val("DESC");
					$("#othPaymentSortBy").val(this.id);
					displayPaymentType();
				}else if($(this).hasClass("fa-sort")){
					if($("#othPaymentSortType").val() == "ASC"){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#othPaymentSortType").val("DESC");
						$("#othPaymentSortBy").val(this.id);
						displayPaymentType();
					}else{
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#othPaymentSortType").val("ASC");
						$("#othPaymentSortBy").val(this.id);
						displayPaymentType();
					}
				}
			});
		});
	});
	
	function displayPaymentType(){
		var othPaymentSortBy = $('#othPaymentSortBy').val();
		var othPaymentSortType = $('#othPaymentSortType').val();
	    var page = $("#txtPagePaymentType").val();
		var key = $("#txtsearchPaymentType").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_payment/class.php',
			data: 'page=' + page + '&key=' + key + '&othPaymentSortBy=' + othPaymentSortBy + '&othPaymentSortType=' + othPaymentSortType + '&form=displayPaymentType',
			success: function(data){
				if(data == ''){
					$("#tblrefPaymentType").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblrefPaymentType").html(data);
				}
			}, complete: function(){
				PaymentTypeSelected();
				loadEntriesPaymentType();
				loadPagePaymentType();
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
			}
		})
	}

	function loadEntriesPaymentType(){
	    var page = $("#txtPagePaymentType").val();
	    var key = $("#txtsearchPaymentType").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/oth_payment/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesPaymentType',
	        success: function(data){
	            $("#txtEntriesPaymentType").text(data);
	        }
	    });
	}

	function loadPagePaymentType(){
	    var page = $("#txtPagePaymentType").val();
	    var key = $("#txtsearchPaymentType").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/oth_payment/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPagePaymentType',
	        success: function(data){
	            $("#ulPagePaymentType").html(data);
	        }
	    });
	}

    function fncPagePaymentType(page, pagenums){
        $(".pgnumPaymentType").removeClass("active");
        $("#pgPaymentType" + pagenums).addClass("active");
        $("#txtPagePaymentType").val(page);
        displayPaymentType();
    }

	function PaymentTypeSelected(){
		$("#tblrefPaymentType tr").each(function(){
			$(this).click(function(){
				$("#tblrefPaymentType tr").removeClass("selected");
				$(this).addClass("selected");
				selectedPaymentType(this.id);
			})
		})
	}

	function selectedPaymentType(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_payment/class.php',
			data: 'id=' + id + '&form=selectedPaymentType',
			success: function(data){
				var arr = data.split("|");
				$("#txtrefPaymentType").val(arr[0]).trigger("change");
				$("#txtRefPaymentCode").val(arr[1]);
				$("#txtRefPaymentDescription").val(arr[2]);
				$("#hiddenPaymentTypeid").val(id);
			}
		})
	}

	function clickAddPaymentType(){
		$("#tblrefPaymentType tr").unbind("click");
		$("#tblrefPaymentType tr").removeClass("selected");
		$("#buttonsPaymentType").css("display", "none");
		$("#savingbuttonsPaymentType").css("display", "block");
		$(".txtPaymentType").removeAttr("readonly");
		$("#txtrefPaymentType").prop("disabled", false);
		$(".txtPaymentType").val("");
	}

	function cancelbuttonPaymentType(){
		displayPaymentType();
		$("#buttonsPaymentType").css("display", "block");
		$("#savingbuttonsPaymentType").css("display", "none");
		$(".txtPaymentType").attr("readonly", "readonly");
		$("#txtrefPaymentType").prop("disabled", true);
		$(".txtPaymentType").val("");
	}

	function cancelbuttonPaymentType2(){
		displayPaymentType();
		$("#buttonsPaymentType").css("display", "block");
		$("#updatebuttonsPaymentType").css("display", "none");
		$(".txtPaymentType").attr("readonly", "readonly");
		$("#txtrefPaymentType").prop("disabled", true);
	}

	function fncSavePaymentType(){
		var PaymentType = $("#txtrefPaymentType").val();
		var PaymentTypeCode = $("#txtRefPaymentCode").val();
		var PaymentTypeDesc = $("#txtRefPaymentDescription").val();
		if(PaymentType != "" && PaymentTypeCode != "" && PaymentTypeDesc != ""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/oth_payment/class.php',
				data: 'PaymentType=' + PaymentType + '&PaymentTypeCode=' + PaymentTypeCode + '&PaymentTypeDesc=' + PaymentTypeDesc + '&form=fncSavePaymentType',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Payment Type successfully saved.", "cancelbuttonPaymentType", null, "", null, "0");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", data, "", null, "", null, "1");
						}, 500)
					}
				}
			})
		}else{
		  	setTimeout(function(){
				showmodal("alert", "Please fill all fields", "", null, "", null, "1");
			}, 500)
		}
	}

	function clickUpdatePaymentType(){
		var PaymentCode = $("#txtRefPaymentCode").val();
		if(PaymentCode == ""){
			setTimeout(function(){
				showmodal("alert", "Select payment type first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/oth_payment/class.php',
				data: 'PaymentCode=' + PaymentCode + '&form=clickUpdatePaymentType',
				success: function(data){
					if(data == 0){
						$("#tblrefPaymentType tr").unbind("click");
						$("#buttonsPaymentType").css("display", "none");
						$("#updatebuttonsPaymentType").css("display", "block");
						$(".txtPaymentType").removeAttr("readonly");
						$("#txtRefPaymentCode").removeAttr("readonly");
						$("#txtrefPaymentType").prop("disabled", false);
					}else{
						$("#tblrefPaymentType tr").unbind("click");
						$("#buttonsPaymentType").css("display", "none");
						$("#updatebuttonsPaymentType").css("display", "block");
						$(".txtPaymentType").removeAttr("readonly");
						$("#txtRefPaymentCode").attr("readonly", "readonly");
						$("#txtrefPaymentType").prop("disabled", false);
					}
				}
			})
		}
	}

	function updatePaymentType() {
		var hiddenPaymentTypeid = $("#hiddenPaymentTypeid").val();
		var PaymentType = $("#txtrefPaymentType").val();
		var PaymentTypeCode = $("#txtRefPaymentCode").val();
		var PaymentTypeDesc = $("#txtRefPaymentDescription").val();
		if(PaymentType != "" && PaymentTypeCode != "" && PaymentTypeDesc != ""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/oth_payment/class.php',
				data: 'hiddenPaymentTypeid=' + hiddenPaymentTypeid + '&PaymentType=' + PaymentType + '&PaymentTypeCode=' + PaymentTypeCode + '&PaymentTypeDesc=' + PaymentTypeDesc + '&form=updatePaymentType',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Bank Name successfully updated.", "cancelbuttonPaymentType2", null, "", null, "0");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", data, "", null, "", null, "1");
						}, 500)
					}
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields", "", null, "", null, "1");
			}, 500)
		}
	}

	function clickDeletePaymentType() {
		var PaymentCode = $("#txtRefPaymentCode").val();
		var PaymentTypeDesc = $("#txtRefPaymentDescription").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/oth_payment/class.php',
			data: 'PaymentCode=' + PaymentCode + '&form=clickUpdatePaymentType',
			success: function(data){
				if(data == 0){
					if(PaymentCode == ""){
						setTimeout(function(){
							showmodal("alert", "Select payment type first", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("confirm", "Are you sure you want to delete " + PaymentTypeDesc, "clickDeletePaymentType2", null, "", null, "0");
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

	function clickDeletePaymentType2(){
		var hiddenPaymentTypeid = $("#hiddenPaymentTypeid").val();
		var PaymentTypeDesc = $("#txtRefPaymentDescription").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_payment/class.php',
			data: 'hiddenPaymentTypeid=' + hiddenPaymentTypeid + '&form=deleteBank',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", PaymentTypeDesc + " has been deleted.", "displayPaymentType", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidatePaymentType(){
		var key = $('#txtsearchPaymentType').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_payment/class.php',
			data: 'key=' + key + '&form=AutoConsolidatePaymentType',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of payment type successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of payment type.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>