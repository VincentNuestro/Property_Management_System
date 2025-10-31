<script type="text/javascript">
	setTimeout(function(){
    	$(".fixTable").tableHeadFixer();
    	$(".ThisIsForCodes").on('keypress', function (event) {
        var regex = new RegExp("^[a-zA-Z!@#$%^*()0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        	if (!regex.test(key)) {
       			event.preventDefault();
       			return false;
    		}
     	});
     	$(".ThisIsForAmounts").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });
	}, 1000)

	function fncChangeJDAMappingTab(ref){
        $(".divJDAMapping").addClass("hide");
        $(".ref"+ref).removeClass("hide");
		$(".dd2-content").css("background-color", "rgb(248, 250, 255)");
		$(".dd2-content").css("color", "rgb(124, 158, 178)");
		$("#dd"+ref).css("background-color", "rgb(102, 102, 102)");
		$("#dd"+ref).css("color", "rgb(255, 255, 255)");
	}
	
	
</script>

<!-- COMPANY SCRIPT -->
<script type="text/javascript">
	$(function(){
		$("#txtPageJDACompany").val("1");
		fncShowJDACompany();
		$("#txtSearchJDACompany").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageJDACompany").val("1");
				fncShowJDACompany(); 
			}else if ( x == '8' ){
				if($('#txtSearchJDACompany').val() == ""){
					$("#txtPageJDACompany").val("1");
					fncShowJDACompany();
				}
			}
		});
	})

	function fncShowJDACompany(){
	    var page = $("#txtPageJDACompany").val();
		var key = $("#txtSearchJDACompany").val();
		$.ajax({
			type: 'POST',
			url: 'setup/jdamapping/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncShowJDACompany',
			success: function(data){
				$("#tblrefJDACompany").html(data);
			}, complete: function(){
				fncClickJDACompany();
				fncLoadJDACompanyEntries();
				fncLoadJDACompanyPageNum();
				$(".txtClearJDACompany").val("");
			}
		})
	}

	function fncLoadJDACompanyEntries(){
	    var page = $("#txtPageJDACompany").val();
	    var key = $("#txtSearchJDACompany").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDACompanyEntries',
	        success: function(data){
	            $("#txtEntriesJDACompany").text(data);
	        }
	    });
	}

	function fncLoadJDACompanyPageNum(){
	    var page = $("#txtPageJDACompany").val();
	    var key = $("#txtSearchJDACompany").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDACompanyPageNum',
	        success: function(data){
	            $("#ulPageJDACompany").html(data);
	        }
	    });
	}

    function fncLoadJDACompanyPageFunc(page, pagenums){
        $(".pgnumMainCat").removeClass("active");
        $("#pgnumJDACompany" + pagenums).addClass("active");
        $("#txtPageJDACompany").val(page);
        fncShowJDACompany();
    }

	function fncClickJDACompany(){
		$("#tblrefJDACompany tr").each(function(){
			$(this).click(function(){
				$("#tblrefJDACompany tr").removeClass("selected");
				$(this).addClass("selected");
				var arr = $(this).attr("id").split("|");
				$("#txtJDACompanyID").val(arr[0]);
				$("#txtJDACompanyCode").val(arr[1]);
			})
		})
	}

	function fncClickEditJDACompany(){
		var JDACode = $("#txtJDACompanyID").val();
		if(JDACode == ""){
			setTimeout(function(){
				showmodal("alert", "Please select Company first.", "", null, "", null, "1");
			}, 500)
		}else{
			$("#txtJDACompanyCode").removeAttr("readonly");
			$("#btnEditJDACompany").css("display", "none");
			$("#btnSavingJDACompany").css("display", "block");
			$("#tblrefJDACompany tr").unbind("click");
		}
	}

	function fncClickCancelJDACompany(){
		$("#txtJDACompanyCode").attr("readonly", "readonly");
		$("#btnEditJDACompany").css("display", "block");
		$("#btnSavingJDACompany").css("display", "none");
		fncClickJDACompany();
	}

	function fncClickCancelJDACompanyFinal(){
		$("#txtJDACompanyCode").attr("readonly", "readonly");
		$("#btnEditJDACompany").css("display", "block");
		$("#btnSavingJDACompany").css("display", "none");
		$(".txtClearJDACompany").val("");
		fncShowJDACompany();
	}

	function fncClickSaveJDACompany(){
		$("#btnJDASaveCompany").button("loading");
		var CompanyID = $("#txtJDACompanyID").val();
		var JDACode = $("#txtJDACompanyCode").val();
		if(CompanyID == ""){
			$("#btnJDASaveCompany").button("reset");
			setTimeout(function(){
				showmodal("alert", "Failed to update JDA_Company Code", "", null, "", null, "1");
			}, 500)
		}else{
			if(JDACode == ""){
				$("#btnJDASaveCompany").button("reset");
				setTimeout(function(){
					showmodal("alert", "Please type in the JDA_Company Code", "", null, "", null, "1");
				}, 500)
			}else{
				$.ajax({
					type: 'POST',
					url: 'setup/jdamapping/class.php',
					data: 'CompanyID=' + CompanyID + '&JDACode=' + JDACode + '&form=fncClickSaveJDACompany',
					success: function(data){
						$("#btnJDASaveCompany").button("reset");
						if(data == "1"){
							setTimeout(function(){
								showmodal("alert", "JDA_Company Code successfully saved.", "fncClickCancelJDACompanyFinal", null, "", null, "0");
							}, 500)
						}else if(data == "2"){
							setTimeout(function(){
								showmodal("alert", "JDA_Company Code already exist.", "", null, "", null, "1");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", "Failed to save JDA_Company Code.", "", null, "", null, "1");
							}, 500)
						}
					}
				})
			}
		}
	}
</script>
<!-- COMPANY SCRIPT -->

<!-- MALL SCRIPT -->
<script type="text/javascript">
	$(function(){
		$("#txtPageJDAMall").val("1");
		fncShowJDAMall();
		$("#txtSearchJDAMall").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageJDAMall").val("1");
				fncShowJDAMall(); 
			}else if ( x == '8' ){
				if($('#txtSearchJDAMall').val() == ""){
					$("#txtPageJDAMall").val("1");
					fncShowJDAMall();
				}
			}
		});
	})

	function fncShowJDAMall(){
	    var page = $("#txtPageJDAMall").val();
		var key = $("#txtSearchJDAMall").val();
		$.ajax({
			type: 'POST',
			url: 'setup/jdamapping/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncShowJDAMall',
			success: function(data){
				$("#tblrefJDAMall").html(data);
			}, complete: function(){
				fncClickJDAMall();
				fncLoadJDAMallEntries();
				fncLoadJDAMallPageNum();
				$(".txtClearJDAMall").val("");
			}
		})
	}

	function fncLoadJDAMallEntries(){
	    var page = $("#txtPageJDAMall").val();
	    var key = $("#txtSearchJDAMall").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAMallEntries',
	        success: function(data){
	            $("#txtEntriesJDAMall").text(data);
	        }
	    });
	}

	function fncLoadJDAMallPageNum(){
	    var page = $("#txtPageJDAMall").val();
	    var key = $("#txtSearchJDAMall").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAMallPageNum',
	        success: function(data){
	            $("#ulPageJDAMall").html(data);
	        }
	    });
	}

    function fncLoadJDAMallPageFunc(page, pagenums){
        $(".pgnumMainCat").removeClass("active");
        $("#pgnumJDAMall" + pagenums).addClass("active");
        $("#txtPageJDAMall").val(page);
        fncShowJDAMall();
    }

	function fncClickJDAMall(){
		$("#tblrefJDAMall tr").each(function(){
			$(this).click(function(){
				$("#tblrefJDAMall tr").removeClass("selected");
				$(this).addClass("selected");
				var arr = $(this).attr("id").split("|");
				$("#txtJDAMallID").val(arr[0]);
				$("#txtJDAMallCode").val(arr[1]);
			})
		})
	}

	function fncClickEditJDAMall(){
		var JDACode = $("#txtJDAMallID").val();
		if(JDACode == ""){
			setTimeout(function(){
				showmodal("alert", "Please select Mall first.", "", null, "", null, "1");
			}, 500)
		}else{
			$("#txtJDAMallCode").removeAttr("readonly");
			$("#btnEditJDAMall").css("display", "none");
			$("#btnSavingJDAMall").css("display", "block");
			$("#tblrefJDAMall tr").unbind("click");
		}
	}

	function fncClickCancelJDAMall(){
		$("#txtJDAMallCode").attr("readonly", "readonly");
		$("#btnEditJDAMall").css("display", "block");
		$("#btnSavingJDAMall").css("display", "none");
		fncClickJDAMall();
	}

	function fncClickCancelJDAMallFinal(){
		$("#txtJDAMallCode").attr("readonly", "readonly");
		$("#btnEditJDAMall").css("display", "block");
		$("#btnSavingJDAMall").css("display", "none");
		$(".txtClearJDAMall").val("");
		fncShowJDAMall();
	}

	function fncClickSaveJDAMall(){
		$("#btnJDASaveMall").button("loading");
		var MallID = $("#txtJDAMallID").val();
		var JDACode = $("#txtJDAMallCode").val();
		if(MallID == ""){
			$("#btnJDASaveMall").button("reset");
			setTimeout(function(){
				showmodal("alert", "Failed to update JDA_Mall Code", "", null, "", null, "1");
			}, 500)
		}else{
			if(JDACode == ""){
				$("#btnJDASaveMall").button("reset");
				setTimeout(function(){
					showmodal("alert", "Please type in the JDA_Mall Code", "", null, "", null, "1");
				}, 500)
			}else{
				$.ajax({
					type: 'POST',
					url: 'setup/jdamapping/class.php',
					data: 'MallID=' + MallID + '&JDACode=' + JDACode + '&form=fncClickSaveJDAMall',
					success: function(data){
						$("#btnJDASaveMall").button("reset");
						if(data == "1"){
							setTimeout(function(){
								showmodal("alert", "JDA_Mall Code successfully saved.", "fncClickCancelJDAMallFinal", null, "", null, "0");
							}, 500)
						}else if(data == "2"){
							setTimeout(function(){
								showmodal("alert", "JDA_Mall Code already exist.", "", null, "", null, "1");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", "Failed to save JDA_Mall Code.", "", null, "", null, "1");
							}, 500)
						}
					}
				})
			}
		}
	}
</script>
<!-- MALL SCRIPT -->

<!-- TENANT SCRIPT -->
<script type="text/javascript">
	$(function(){
		$("#txtPageJDATenant").val("1");
		fncShowJDATenant();
		$("#txtSearchJDATenant").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageJDATenant").val("1");
				fncShowJDATenant(); 
			}else if ( x == '8' ){
				if($('#txtSearchJDATenant').val() == ""){
					$("#txtPageJDATenant").val("1");
					fncShowJDATenant();
				}
			}
		});
	})

	function fncShowJDATenant(){
	    var page = $("#txtPageJDATenant").val();
		var key = $("#txtSearchJDATenant").val();
		$.ajax({
			type: 'POST',
			url: 'setup/jdamapping/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncShowJDATenant',
			success: function(data){
				$("#tblrefJDATenant").html(data);
			}, complete: function(){
				fncClickJDATenant();
				fncLoadJDATenantEntries();
				fncLoadJDATenantPageNum();
				$(".txtClearJDATenant").val("");
			}
		})
	}

	function fncLoadJDATenantEntries(){
	    var page = $("#txtPageJDATenant").val();
	    var key = $("#txtSearchJDATenant").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDATenantEntries',
	        success: function(data){
	            $("#txtEntriesJDATenant").text(data);
	        }
	    });
	}

	function fncLoadJDATenantPageNum(){
	    var page = $("#txtPageJDATenant").val();
	    var key = $("#txtSearchJDATenant").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDATenantPageNum',
	        success: function(data){
	            $("#ulPageJDATenant").html(data);
	        }
	    });
	}

    function fncLoadJDATenantPageFunc(page, pagenums){
        $(".pgnumMainCat").removeClass("active");
        $("#pgnumJDATenant" + pagenums).addClass("active");
        $("#txtPageJDATenant").val(page);
        fncShowJDATenant();
    }

	function fncClickJDATenant(){
		$("#tblrefJDATenant tr").each(function(){
			$(this).click(function(){
				$("#tblrefJDATenant tr").removeClass("selected");
				$(this).addClass("selected");
				var arr = $(this).attr("id").split("|");
				$("#txtJDATenantID").val(arr[0]);
				$("#txtJDATenantCode").val(arr[1]);
				$("#txtJDATenantisVendor").val(arr[2]).trigger("change");
				$("#txtJDATenantVendorCode").val(arr[3]);
				$("#txtJDATenantVendorLocationCode").val(arr[4]);
				$("#txtJDATenantCompID").val(arr[5]);
				$("#txtJDATenantBeg_Date").val(arr[6]);
				$("#txtJDATenantBeg_Balance").val(arr[7]);
			})
		})
	}

	function fncClickEditJDATenant(){
		var JDACode = $("#txtJDATenantID").val();
		var isVendor = $("#txtJDATenantisVendor").val();
		if(JDACode == ""){
			setTimeout(function(){
				showmodal("alert", "Please select Tenant first.", "", null, "", null, "1");
			}, 500)
		}else{
			$(".txtEditJDATenant").removeAttr("readonly");
			$("#txtJDATenantisVendor").prop("disabled", false);
			$("#btnEditJDATenant").css("display", "none");
			$("#btnSavingJDATenant").css("display", "block");
			$("#tblrefJDATenant tr").unbind("click");
			fncisVendor();
		}
	}

	function fncClickCancelJDATenant(){
		$(".txtEditJDATenant").attr("readonly", "readonly");
		$("#txtJDATenantisVendor").prop("disabled", true);
		$("#btnEditJDATenant").css("display", "block");
		$("#btnSavingJDATenant").css("display", "none");
		fncClickJDATenant();
	}

	function fncClickCancelJDATenantFinal(){
		$(".txtEditJDATenant").attr("readonly", "readonly");
		$("#txtJDATenantisVendor").prop("disabled", true);
		$("#btnEditJDATenant").css("display", "block");
		$("#btnSavingJDATenant").css("display", "none");
		$(".txtClearJDATenant").val("");
		fncShowJDATenant();
	}

	function fncClickSaveJDATenant(){
		$("#btnJDASaveMall").button("loading");
		var TenantID = $("#txtJDATenantID").val();
		var JDACode = $("#txtJDATenantCode").val();
		var isVendor = $("#txtJDATenantisVendor").val();
		var VendorCode = $("#txtJDATenantVendorCode").val();
		var CompID = $("#txtJDATenantCompID").val();
		var Beg_Date = $("#txtJDATenantBeg_Date").val();
		var Beg_Balance = $("#txtJDATenantBeg_Balance").val().replace(/,/g,"");
		var VendorLocation = $("#txtJDATenantVendorLocationCode").val();
		if(TenantID == ""){
			$("#btnJDASaveMall").button("reset");
			setTimeout(function(){
				showmodal("alert", "Failed to update JDA Code", "", null, "", null, "1");
			}, 500)
		}else{
			if(isVendor == "1" && (VendorCode == "" || VendorLocation == "")){
				$("#btnJDASaveMall").button("reset");
				setTimeout(function(){
					showmodal("alert", "Please type in the JDA Code", "", null, "", null, "1");
				}, 500)
			}else{
				$.ajax({
					type: 'POST',
					url: 'setup/jdamapping/class.php',
					data: 'TenantID=' + TenantID + '&JDACode=' + JDACode + '&isVendor=' + isVendor + '&VendorCode=' + VendorCode + '&CompID=' + CompID + '&Beg_Date=' + Beg_Date + '&Beg_Balance=' + Beg_Balance + '&VendorLocation=' + VendorLocation + '&form=fncClickSaveJDATenant',
					success: function(data){
						$("#btnJDASaveMall").button("reset");
						if(data == "1"){
							setTimeout(function(){
								showmodal("alert", "JDA Code successfully saved.", "fncClickCancelJDATenantFinal", null, "", null, "0");
							}, 500)
						}else if(data == "2"){
							setTimeout(function(){
								showmodal("alert", "JDA Code already exist.", "", null, "", null, "1");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", "Failed to save JDA Code.", "", null, "", null, "1");
							}, 500)
						}
					}
				})
			}
		}
	}

	function fncisVendor(){
		var isVendor = $("#txtJDATenantisVendor").val();
		if(isVendor == 0){
			$(".isVendorYes").addClass("hide");
		}else{
			$(".isVendorYes").removeClass("hide");
		}
	}
</script>
<!-- TENANT SCRIPT -->

<!-- PAYMENT TYPE SCRIPT -->
<script type="text/javascript">
	$(function(){
		$("#txtPageJDAPaymentType").val("1");
		fncShowJDAPaymentType();
		$("#txtSearchJDAPaymentType").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageJDAPaymentType").val("1");
				fncShowJDAPaymentType(); 
			}else if ( x == '8' ){
				if($('#txtSearchJDAPaymentType').val() == ""){
					$("#txtPageJDAPaymentType").val("1");
					fncShowJDAPaymentType();
				}
			}
		});
	})

	function fncShowJDAPaymentType(){
	    var page = $("#txtPageJDAPaymentType").val();
		var key = $("#txtSearchJDAPaymentType").val();
		$.ajax({
			type: 'POST',
			url: 'setup/jdamapping/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncShowJDAPaymentType',
			success: function(data){
				$("#tblrefJDAPaymentType").html(data);
			}, complete: function(){
				fncClickJDAPaymentType();
				fncLoadJDAPaymentTypeEntries();
				fncLoadJDAPaymentTypePageNum();
				$(".txtClearJDAPaymentType").val("");
			}
		})
	}

	function fncLoadJDAPaymentTypeEntries(){
	    var page = $("#txtPageJDAPaymentType").val();
	    var key = $("#txtSearchJDAPaymentType").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAPaymentTypeEntries',
	        success: function(data){
	            $("#txtEntriesJDAPaymentType").text(data);
	        }
	    });
	}

	function fncLoadJDAPaymentTypePageNum(){
	    var page = $("#txtPageJDAPaymentType").val();
	    var key = $("#txtSearchJDAPaymentType").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAPaymentTypePageNum',
	        success: function(data){
	            $("#ulPageJDAPaymentType").html(data);
	        }
	    });
	}

    function fncLoadJDAPaymentTypePageFunc(page, pagenums){
        $(".pgnumMainCat").removeClass("active");
        $("#pgnumJDAPaymentType" + pagenums).addClass("active");
        $("#txtPageJDAPaymentType").val(page);
        fncShowJDAPaymentType();
    }

	function fncClickJDAPaymentType(){
		$("#tblrefJDAPaymentType tr").each(function(){
			$(this).click(function(){
				$("#tblrefJDAPaymentType tr").removeClass("selected");
				$(this).addClass("selected");
				var arr = $(this).attr("id").split("|");
				$("#txtJDAPaymentTypeID").val(arr[0]);
				$("#txtJDAPaymentTypePayCode").val(arr[1]);
				$("#txtJDAPaymentTypeDr_COA").val(arr[2]);
				$("#txtJDAPaymentTypeCr_COA").val(arr[3]);
			})
		})
	}

	function fncClickEditJDAPaymentType(){
		var JDACode = $("#txtJDAPaymentTypeID").val();
		if(JDACode == ""){
			setTimeout(function(){
				showmodal("alert", "Please select Payment Type first.", "", null, "", null, "1");
			}, 500)
		}else{
			$(".txtEditJDAPaymentType").removeAttr("readonly");
			$("#txtJDAPaymentTypeisVendor").prop("disabled", false);
			$("#btnEditJDAPaymentType").css("display", "none");
			$("#btnSavingJDAPaymentType").css("display", "block");
			$("#tblrefJDAPaymentType tr").unbind("click");
		}
	}

	function fncClickCancelJDAPaymentType(){
		$(".txtEditJDAPaymentType").attr("readonly", "readonly");
		$("#txtJDAPaymentTypeisVendor").prop("disabled", true);
		$("#btnEditJDAPaymentType").css("display", "block");
		$("#btnSavingJDAPaymentType").css("display", "none");
		fncClickJDAPaymentType();
	}

	function fncClickCancelJDAPaymentTypeFinal(){
		$(".txtEditJDAPaymentType").attr("readonly", "readonly");
		$("#txtJDAPaymentTypeisVendor").prop("disabled", true);
		$("#btnEditJDAPaymentType").css("display", "block");
		$("#btnSavingJDAPaymentType").css("display", "none");
		$(".txtClearJDAPaymentType").val("");
		fncShowJDAPaymentType();
	}

	function fncClickSaveJDAPaymentType(){
		$("#btnJDASaveMall").button("loading");
		var PaymentTypeID = $("#txtJDAPaymentTypeID").val();
		var JDA_Pay_Code = $("#txtJDAPaymentTypePayCode").val();
		var Dr_COA = $("#txtJDAPaymentTypeDr_COA").val();
		var Cr_COA = $("#txtJDAPaymentTypeCr_COA").val();
		if(PaymentTypeID == ""){
			$("#btnJDASaveMall").button("reset");
			setTimeout(function(){
				showmodal("alert", "Failed to update JDA Code", "", null, "", null, "1");
			}, 500)
		}else{
			// if(JDA_Pay_Code == ""){
			// 	$("#btnJDASaveMall").button("reset");
			// 	setTimeout(function(){
			// 		showmodal("alert", "Please type in the JDA Code", "", null, "", null, "1");
			// 	}, 500)
			// }else{
				$.ajax({
					type: 'POST',
					url: 'setup/jdamapping/class.php',
					data: 'PaymentTypeID=' + PaymentTypeID + '&JDA_Pay_Code=' + JDA_Pay_Code + '&Dr_COA=' + Dr_COA + '&Cr_COA=' + Cr_COA + '&form=fncClickSaveJDAPaymentType',
					success: function(data){
						$("#btnJDASaveMall").button("reset");
						if(data == "1"){
							setTimeout(function(){
								showmodal("alert", "JDA Code successfully saved.", "fncClickCancelJDAPaymentTypeFinal", null, "", null, "0");
							}, 500)
						}else if(data == "2"){
							setTimeout(function(){
								showmodal("alert", "JDA Code already exist.", "", null, "", null, "1");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", "Failed to save JDA Code.", "", null, "", null, "1");
							}, 500)
						}
					}
				})
			// }
		}
	}
</script>
<!-- PAYMENT TYPE SCRIPT -->

<!-- MAINTENANCE SCRIPT -->
<script type="text/javascript">
	$(function(){
		$("#txtPageJDAMaintenance").val("1");
		fncShowJDAMaintenance();
		$("#txtSearchJDAMaintenance").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageJDAMaintenance").val("1");
				fncShowJDAMaintenance(); 
			}else if ( x == '8' ){
				if($('#txtSearchJDAMaintenance').val() == ""){
					$("#txtPageJDAMaintenance").val("1");
					fncShowJDAMaintenance();
				}
			}
		});
	})

	function fncShowJDAMaintenance(){
	    var page = $("#txtPageJDAMaintenance").val();
		var key = $("#txtSearchJDAMaintenance").val();
		$.ajax({
			type: 'POST',
			url: 'setup/jdamapping/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncShowJDAMaintenance',
			success: function(data){
				$("#tblrefJDAMaintenance").html(data);
			}, complete: function(){
				fncClickJDAMaintenance();
				fncLoadJDAMaintenanceEntries();
				fncLoadJDAMaintenancePageNum();
				$(".txtClearJDAMaintenance").val("");
			}
		})
	}

	function fncLoadJDAMaintenanceEntries(){
	    var page = $("#txtPageJDAMaintenance").val();
	    var key = $("#txtSearchJDAMaintenance").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAMaintenanceEntries',
	        success: function(data){
	            $("#txtEntriesJDAMaintenance").text(data);
	        }
	    });
	}

	function fncLoadJDAMaintenancePageNum(){
	    var page = $("#txtPageJDAMaintenance").val();
	    var key = $("#txtSearchJDAMaintenance").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAMaintenancePageNum',
	        success: function(data){
	            $("#ulPageJDAMaintenance").html(data);
	        }
	    });
	}

    function fncLoadJDAMaintenancePageFunc(page, pagenums){
        $(".pgnumMainCat").removeClass("active");
        $("#pgnumJDAMaintenance" + pagenums).addClass("active");
        $("#txtPageJDAMaintenance").val(page);
        fncShowJDAMaintenance();
    }

	function fncClickJDAMaintenance(){
		$("#tblrefJDAMaintenance tr").each(function(){
			$(this).click(function(){
				$("#tblrefJDAMaintenance tr").removeClass("selected");
				$(this).addClass("selected");
				var arr = $(this).attr("id").split("|");
				$("#txtJDAMaintenanceID").val(arr[0]);
				$("#txtJDAMaintenanceLssrMjr").val(arr[1]);
				$("#txtJDAMaintenanceLssrMnr").val(arr[2]);
				$("#txtJDAMaintenanceLssrCOAStore").val(arr[3]);
				$("#txtJDAMaintenanceVndrMjr").val(arr[4]);
				$("#txtJDAMaintenanceVndrMnr").val(arr[5]);
				$("#txtJDAMaintenanceVndrCOAStore").val(arr[6]);
				$("#txtJDAMaintenanceWthTaxRate").val(arr[7]);
			})
		})
	}

	function fncClickEditJDAMaintenance(){
		var JDACode = $("#txtJDAMaintenanceID").val();
		if(JDACode == ""){
			setTimeout(function(){
				showmodal("alert", "Please select Maintenance first.", "", null, "", null, "1");
			}, 500)
		}else{
			$(".txtEditJDAMaintenance").removeAttr("readonly");
			$("#txtJDAMaintenanceisVendor").prop("disabled", false);
			$("#btnEditJDAMaintenance").css("display", "none");
			$("#btnSavingJDAMaintenance").css("display", "block");
			$("#tblrefJDAMaintenance tr").unbind("click");
		}
	}

	function fncClickCancelJDAMaintenance(){
		$(".txtEditJDAMaintenance").attr("readonly", "readonly");
		$("#txtJDAMaintenanceisVendor").prop("disabled", true);
		$("#btnEditJDAMaintenance").css("display", "block");
		$("#btnSavingJDAMaintenance").css("display", "none");
		fncClickJDAMaintenance();
	}

	function fncClickCancelJDAMaintenanceFinal(){
		$(".txtEditJDAMaintenance").attr("readonly", "readonly");
		$("#txtJDAMaintenanceisVendor").prop("disabled", true);
		$("#btnEditJDAMaintenance").css("display", "block");
		$("#btnSavingJDAMaintenance").css("display", "none");
		$(".txtClearJDAMaintenance").val("");
		fncShowJDAMaintenance();
	}

	function fncClickSaveJDAMaintenance(){
		$("#btnJDASaveMall").button("loading");
		var TaskID = $("#txtJDAMaintenanceID").val();
		var LssrMjr = $("#txtJDAMaintenanceLssrMjr").val();
		var LssrMnr = $("#txtJDAMaintenanceLssrMnr").val();
		var LssrCOAStore = $("#txtJDAMaintenanceLssrCOAStore").val();
		var VndrMjr = $("#txtJDAMaintenanceVndrMjr").val();
		var VndrMnr = $("#txtJDAMaintenanceVndrMnr").val();
		var VndrCOAStore = $("#txtJDAMaintenanceVndrCOAStore").val();
		var WthTaxRate = $("#txtJDAMaintenanceWthTaxRate").val();
		if(TaskID == ""){
			$("#btnJDASaveMall").button("reset");
			setTimeout(function(){
				showmodal("alert", "Failed to update JDA Code", "", null, "", null, "1");
			}, 500)
		}else{
			// if(JDA_Charge_Code == ""){
			// 	$("#btnJDASaveMall").button("reset");
			// 	setTimeout(function(){
			// 		showmodal("alert", "Please type in the JDA Code", "", null, "", null, "1");
			// 	}, 500)
			// }else{
				$.ajax({
					type: 'POST',
					url: 'setup/jdamapping/class.php',
					data: 'TaskID=' + TaskID + '&LssrMjr=' + LssrMjr + '&LssrMnr=' + LssrMnr + '&LssrCOAStore=' + LssrCOAStore + '&VndrMjr=' + VndrMjr + '&VndrMnr=' + VndrMnr + '&VndrCOAStore=' + VndrCOAStore + '&WthTaxRate=' + WthTaxRate + '&form=fncClickSaveJDAMaintenance',
					success: function(data){
						$("#btnJDASaveMall").button("reset");
						if(data == "1"){
							setTimeout(function(){
								showmodal("alert", "JDA Code successfully saved.", "fncClickCancelJDAMaintenanceFinal", null, "", null, "0");
							}, 500)
						}else if(data == "2"){
							setTimeout(function(){
								showmodal("alert", "JDA Code already exist.", "", null, "", null, "1");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", "Failed to save JDA Code.", "", null, "", null, "1");
							}, 500)
						}
					}
				})
			// }
		}
	}
</script>
<!-- MAINTENANCE SCRIPT -->

<!-- CHARGES SCRIPT -->
<script type="text/javascript">
	$(function(){
		$("#txtPageJDACharges").val("1");
		fncShowJDACharges();
		$("#txtSearchJDACharges").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageJDACharges").val("1");
				fncShowJDACharges(); 
			}else if ( x == '8' ){
				if($('#txtSearchJDACharges').val() == ""){
					$("#txtPageJDACharges").val("1");
					fncShowJDACharges();
				}
			}
		});
	})

	function fncShowJDACharges(){
	    var page = $("#txtPageJDACharges").val();
		var key = $("#txtSearchJDACharges").val();
		$.ajax({
			type: 'POST',
			url: 'setup/jdamapping/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncShowJDACharges',
			success: function(data){
				$("#tblrefJDACharges").html(data);
			}, complete: function(){
				fncClickJDACharges();
				fncLoadJDAChargesEntries();
				fncLoadJDAChargesPageNum();
				$(".txtClearJDACharges").val("");
			}
		})
	}

	function fncLoadJDAChargesEntries(){
	    var page = $("#txtPageJDACharges").val();
	    var key = $("#txtSearchJDACharges").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAChargesEntries',
	        success: function(data){
	            $("#txtEntriesJDACharges").text(data);
	        }
	    });
	}

	function fncLoadJDAChargesPageNum(){
	    var page = $("#txtPageJDACharges").val();
	    var key = $("#txtSearchJDACharges").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAChargesPageNum',
	        success: function(data){
	            $("#ulPageJDACharges").html(data);
	        }
	    });
	}

    function fncLoadJDAChargesPageFunc(page, pagenums){
        $(".pgnumMainCat").removeClass("active");
        $("#pgnumJDACharges" + pagenums).addClass("active");
        $("#txtPageJDACharges").val(page);
        fncShowJDACharges();
    }

	function fncClickJDACharges(){
		$("#tblrefJDACharges tr").each(function(){
			$(this).click(function(){
				$("#tblrefJDACharges tr").removeClass("selected");
				$(this).addClass("selected");
				var arr = $(this).attr("id").split("|");
				$("#txtJDAChargesID").val(arr[0]);
				$("#txtJDAChargesLssrMjr").val(arr[1]);
				$("#txtJDAChargesLssrMnr").val(arr[2]);
				$("#txtJDAChargesLssrCOAStore").val(arr[3]);
				$("#txtJDAChargesVndrMjr").val(arr[4]);
				$("#txtJDAChargesVndrMnr").val(arr[5]);
				$("#txtJDAChargesVndrCOAStore").val(arr[6]);
				$("#txtJDAChargesWthTaxRate").val(arr[7]);
			})
		})
	}

	function fncClickEditJDACharges(){
		var JDACode = $("#txtJDAChargesID").val();
		if(JDACode == ""){
			setTimeout(function(){
				showmodal("alert", "Please select Charges first.", "", null, "", null, "1");
			}, 500)
		}else{
			$(".txtEditJDACharges").removeAttr("readonly");
			$("#txtJDAChargesisVendor").prop("disabled", false);
			$("#btnEditJDACharges").css("display", "none");
			$("#btnSavingJDACharges").css("display", "block");
			$("#tblrefJDACharges tr").unbind("click");
		}
	}

	function fncClickCancelJDACharges(){
		$(".txtEditJDACharges").attr("readonly", "readonly");
		$("#txtJDAChargesisVendor").prop("disabled", true);
		$("#btnEditJDACharges").css("display", "block");
		$("#btnSavingJDACharges").css("display", "none");
		fncClickJDACharges();
	}

	function fncClickCancelJDAChargesFinal(){
		$(".txtEditJDACharges").attr("readonly", "readonly");
		$("#txtJDAChargesisVendor").prop("disabled", true);
		$("#btnEditJDACharges").css("display", "block");
		$("#btnSavingJDACharges").css("display", "none");
		$(".txtClearJDACharges").val("");
		fncShowJDACharges();
	}

	function fncClickSaveJDACharges(){
		$("#btnJDASaveMall").button("loading");
		var ChargesID = $("#txtJDAChargesID").val();
		var LssrMjr = $("#txtJDAChargesLssrMjr").val();
		var LssrMnr = $("#txtJDAChargesLssrMnr").val();
		var LssrCOAStore = $("#txtJDAChargesLssrCOAStore").val();
		var VndrMjr = $("#txtJDAChargesVndrMjr").val();
		var VndrMnr = $("#txtJDAChargesVndrMnr").val();
		var VndrCOAStore = $("#txtJDAChargesVndrCOAStore").val();
		var WthTaxRate = $("#txtJDAChargesWthTaxRate").val();
		if(ChargesID == ""){
			$("#btnJDASaveMall").button("reset");
			setTimeout(function(){
				showmodal("alert", "Failed to update JDA Code", "", null, "", null, "1");
			}, 500)
		}else{
			// if(JDA_Charge_Code == ""){
			// 	$("#btnJDASaveMall").button("reset");
			// 	setTimeout(function(){
			// 		showmodal("alert", "Please type in the JDA Code", "", null, "", null, "1");
			// 	}, 500)
			// }else{
				$.ajax({
					type: 'POST',
					url: 'setup/jdamapping/class.php',
					data: 'ChargesID=' + ChargesID + '&LssrMjr=' + LssrMjr + '&LssrMnr=' + LssrMnr + '&LssrCOAStore=' + LssrCOAStore + '&VndrMjr=' + VndrMjr + '&VndrMnr=' + VndrMnr + '&VndrCOAStore=' + VndrCOAStore + '&WthTaxRate=' + WthTaxRate + '&form=fncClickSaveJDACharges',
					success: function(data){
						$("#btnJDASaveMall").button("reset");
						if(data == "1"){
							setTimeout(function(){
								showmodal("alert", "JDA Code successfully saved.", "fncClickCancelJDAChargesFinal", null, "", null, "0");
							}, 500)
						}else if(data == "2"){
							setTimeout(function(){
								showmodal("alert", "JDA Code already exist.", "", null, "", null, "1");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", "Failed to save JDA Code.", "", null, "", null, "1");
							}, 500)
						}
					}
				})
			// }
		}
	}
</script>
<!-- CHARGES SCRIPT -->

<!-- VIOLATIONS SCRIPT -->
<script type="text/javascript">
	$(function(){
		$("#txtPageJDAViolations").val("1");
		fncShowJDAViolations();
		$("#txtSearchJDAViolations").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageJDAViolations").val("1");
				fncShowJDAViolations(); 
			}else if ( x == '8' ){
				if($('#txtSearchJDAViolations').val() == ""){
					$("#txtPageJDAViolations").val("1");
					fncShowJDAViolations();
				}
			}
		});
	})

	function fncShowJDAViolations(){
	    var page = $("#txtPageJDAViolations").val();
		var key = $("#txtSearchJDAViolations").val();
		$.ajax({
			type: 'POST',
			url: 'setup/jdamapping/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncShowJDAViolations',
			success: function(data){
				$("#tblrefJDAViolations").html(data);
			}, complete: function(){
				fncClickJDAViolations();
				fncLoadJDAViolationsEntries();
				fncLoadJDAViolationsPageNum();
				$(".txtClearJDAViolations").val("");
			}
		})
	}

	function fncLoadJDAViolationsEntries(){
	    var page = $("#txtPageJDAViolations").val();
	    var key = $("#txtSearchJDAViolations").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAViolationsEntries',
	        success: function(data){
	            $("#txtEntriesJDAViolations").text(data);
	        }
	    });
	}

	function fncLoadJDAViolationsPageNum(){
	    var page = $("#txtPageJDAViolations").val();
	    var key = $("#txtSearchJDAViolations").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAViolationsPageNum',
	        success: function(data){
	            $("#ulPageJDAViolations").html(data);
	        }
	    });
	}

    function fncLoadJDAViolationsPageFunc(page, pagenums){
        $(".pgnumMainCat").removeClass("active");
        $("#pgnumJDAViolations" + pagenums).addClass("active");
        $("#txtPageJDAViolations").val(page);
        fncShowJDAViolations();
    }

	function fncClickJDAViolations(){
		$("#tblrefJDAViolations tr").each(function(){
			$(this).click(function(){
				$("#tblrefJDAViolations tr").removeClass("selected");
				$(this).addClass("selected");
				var arr = $(this).attr("id").split("|");
				$("#txtJDAViolationsID").val(arr[0]);
				$("#txtJDAViolationsLssrMjr").val(arr[1]);
				$("#txtJDAViolationsLssrMnr").val(arr[2]);
				$("#txtJDAViolationsLssrCOAStore").val(arr[3]);
				$("#txtJDAViolationsVndrMjr").val(arr[4]);
				$("#txtJDAViolationsVndrMnr").val(arr[5]);
				$("#txtJDAViolationsVndrCOAStore").val(arr[6]);
				$("#txtJDAViolationsWthTaxRate").val(arr[7]);
			})
		})
	}

	function fncClickEditJDAViolations(){
		var JDACode = $("#txtJDAViolationsID").val();
		if(JDACode == ""){
			setTimeout(function(){
				showmodal("alert", "Please select Violation first.", "", null, "", null, "1");
			}, 500)
		}else{
			$(".txtEditJDAViolations").removeAttr("readonly");
			$("#txtJDAViolationsisVendor").prop("disabled", false);
			$("#btnEditJDAViolations").css("display", "none");
			$("#btnSavingJDAViolations").css("display", "block");
			$("#tblrefJDAViolations tr").unbind("click");
		}
	}

	function fncClickCancelJDAViolations(){
		$(".txtEditJDAViolations").attr("readonly", "readonly");
		$("#txtJDAViolationsisVendor").prop("disabled", true);
		$("#btnEditJDAViolations").css("display", "block");
		$("#btnSavingJDAViolations").css("display", "none");
		fncClickJDAViolations();
	}

	function fncClickCancelJDAViolationsFinal(){
		$(".txtEditJDAViolations").attr("readonly", "readonly");
		$("#txtJDAViolationsisVendor").prop("disabled", true);
		$("#btnEditJDAViolations").css("display", "block");
		$("#btnSavingJDAViolations").css("display", "none");
		$(".txtClearJDAViolations").val("");
		fncShowJDAViolations();
	}

	function fncClickSaveJDAViolations(){
		$("#btnJDASaveMall").button("loading");
		var ViolationsID = $("#txtJDAViolationsID").val();
		var LssrMjr = $("#txtJDAViolationsLssrMjr").val();
		var LssrMnr = $("#txtJDAViolationsLssrMnr").val();
		var LssrCOAStore = $("#txtJDAViolationsLssrCOAStore").val();
		var VndrMjr = $("#txtJDAViolationsVndrMjr").val();
		var VndrMnr = $("#txtJDAViolationsVndrMnr").val();
		var VndrCOAStore = $("#txtJDAViolationsVndrCOAStore").val();
		var WthTaxRate = $("#txtJDAViolationsWthTaxRate").val();
		if(ViolationsID == ""){
			$("#btnJDASaveMall").button("reset");
			setTimeout(function(){
				showmodal("alert", "Failed to update JDA Code", "", null, "", null, "1");
			}, 500)
		}else{
			// if(JDA_Violation_Code == ""){
			// 	$("#btnJDASaveMall").button("reset");
			// 	setTimeout(function(){
			// 		showmodal("alert", "Please type in the JDA Code", "", null, "", null, "1");
			// 	}, 500)
			// }else{
				$.ajax({
					type: 'POST',
					url: 'setup/jdamapping/class.php',
					data: 'ViolationsID=' + ViolationsID + '&LssrMjr=' + LssrMjr + '&LssrMnr=' + LssrMnr + '&LssrCOAStore=' + LssrCOAStore + '&VndrMjr=' + VndrMjr + '&VndrMnr=' + VndrMnr + '&VndrCOAStore=' + VndrCOAStore + '&WthTaxRate=' + WthTaxRate + '&form=fncClickSaveJDAViolations',
					success: function(data){
						$("#btnJDASaveMall").button("reset");
						if(data == "1"){
							setTimeout(function(){
								showmodal("alert", "JDA Code successfully saved.", "fncClickCancelJDAViolationsFinal", null, "", null, "0");
							}, 500)
						}else if(data == "2"){
							setTimeout(function(){
								showmodal("alert", "JDA Code already exist.", "", null, "", null, "1");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", "Failed to save JDA Code.", "", null, "", null, "1");
							}, 500)
						}
					}
				})
			// }
		}
	}
</script>
<!-- VIOLATIONS SCRIPT -->

<!-- PENALTIES SCRIPT -->
<script type="text/javascript">
	$(function(){
		$("#txtPageJDAPenalties").val("1");
		fncShowJDAPenalties();
		$("#txtSearchJDAPenalties").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageJDAPenalties").val("1");
				fncShowJDAPenalties(); 
			}else if ( x == '8' ){
				if($('#txtSearchJDAPenalties').val() == ""){
					$("#txtPageJDAPenalties").val("1");
					fncShowJDAPenalties();
				}
			}
		});
	})

	function fncShowJDAPenalties(){
	    var page = $("#txtPageJDAPenalties").val();
		var key = $("#txtSearchJDAPenalties").val();
		$.ajax({
			type: 'POST',
			url: 'setup/jdamapping/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncShowJDAPenalties',
			success: function(data){
				$("#tblrefJDAPenalties").html(data);
			}, complete: function(){
				fncClickJDAPenalties();
				fncLoadJDAPenaltiesEntries();
				fncLoadJDAPenaltiesPageNum();
				$(".txtClearJDAPenalties").val("");
			}
		})
	}

	function fncLoadJDAPenaltiesEntries(){
	    var page = $("#txtPageJDAPenalties").val();
	    var key = $("#txtSearchJDAPenalties").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAPenaltiesEntries',
	        success: function(data){
	            $("#txtEntriesJDAPenalties").text(data);
	        }
	    });
	}

	function fncLoadJDAPenaltiesPageNum(){
	    var page = $("#txtPageJDAPenalties").val();
	    var key = $("#txtSearchJDAPenalties").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAPenaltiesPageNum',
	        success: function(data){
	            $("#ulPageJDAPenalties").html(data);
	        }
	    });
	}

    function fncLoadJDAPenaltiesPageFunc(page, pagenums){
        $(".pgnumMainCat").removeClass("active");
        $("#pgnumJDAPenalties" + pagenums).addClass("active");
        $("#txtPageJDAPenalties").val(page);
        fncShowJDAPenalties();
    }

	function fncClickJDAPenalties(){
		$("#tblrefJDAPenalties tr").each(function(){
			$(this).click(function(){
				$("#tblrefJDAPenalties tr").removeClass("selected");
				$(this).addClass("selected");
				var arr = $(this).attr("id").split("|");
				$("#txtJDAPenaltiesID").val(arr[0]);
				$("#txtJDAPenaltiesLssrMjr").val(arr[1]);
				$("#txtJDAPenaltiesLssrMnr").val(arr[2]);
				$("#txtJDAPenaltiesLssrCOAStore").val(arr[3]);
				$("#txtJDAPenaltiesVndrMjr").val(arr[4]);
				$("#txtJDAPenaltiesVndrMnr").val(arr[5]);
				$("#txtJDAPenaltiesVndrCOAStore").val(arr[6]);
				$("#txtJDAPenaltiesWthTaxRate").val(arr[7]);
			})
		})
	}

	function fncClickEditJDAPenalties(){
		var JDACode = $("#txtJDAPenaltiesID").val();
		if(JDACode == ""){
			setTimeout(function(){
				showmodal("alert", "Please select Penalty first.", "", null, "", null, "1");
			}, 500)
		}else{
			$(".txtEditJDAPenalties").removeAttr("readonly");
			$("#txtJDAPenaltiesisVendor").prop("disabled", false);
			$("#btnEditJDAPenalties").css("display", "none");
			$("#btnSavingJDAPenalties").css("display", "block");
			$("#tblrefJDAPenalties tr").unbind("click");
		}
	}

	function fncClickCancelJDAPenalties(){
		$(".txtEditJDAPenalties").attr("readonly", "readonly");
		$("#txtJDAPenaltiesisVendor").prop("disabled", true);
		$("#btnEditJDAPenalties").css("display", "block");
		$("#btnSavingJDAPenalties").css("display", "none");
		fncClickJDAPenalties();
	}

	function fncClickCancelJDAPenaltiesFinal(){
		$(".txtEditJDAPenalties").attr("readonly", "readonly");
		$("#txtJDAPenaltiesisVendor").prop("disabled", true);
		$("#btnEditJDAPenalties").css("display", "block");
		$("#btnSavingJDAPenalties").css("display", "none");
		$(".txtClearJDAPenalties").val("");
		fncShowJDAPenalties();
	}

	function fncClickSaveJDAPenalties(){
		$("#btnJDASaveMall").button("loading");
		var PenaltiesID = $("#txtJDAPenaltiesID").val();
		var LssrMjr = $("#txtJDAPenaltiesLssrMjr").val();
		var LssrMnr = $("#txtJDAPenaltiesLssrMnr").val();
		var LssrCOAStore = $("#txtJDAPenaltiesLssrCOAStore").val();
		var VndrMjr = $("#txtJDAPenaltiesVndrMjr").val();
		var VndrMnr = $("#txtJDAPenaltiesVndrMnr").val();
		var VndrCOAStore = $("#txtJDAPenaltiesVndrCOAStore").val();
		var WthTaxRate = $("#txtJDAPenaltiesWthTaxRate").val();
		if(PenaltiesID == ""){
			$("#btnJDASaveMall").button("reset");
			setTimeout(function(){
				showmodal("alert", "Failed to update JDA Code", "", null, "", null, "1");
			}, 500)
		}else{
			// if(JDA_Penalty_Code == ""){
			// 	$("#btnJDASaveMall").button("reset");
			// 	setTimeout(function(){
			// 		showmodal("alert", "Please type in the JDA Code", "", null, "", null, "1");
			// 	}, 500)
			// }else{
				$.ajax({
					type: 'POST',
					url: 'setup/jdamapping/class.php',
					data: 'PenaltiesID=' + PenaltiesID + '&LssrMjr=' + LssrMjr + '&LssrMnr=' + LssrMnr + '&LssrCOAStore=' + LssrCOAStore + '&VndrMjr=' + VndrMjr + '&VndrMnr=' + VndrMnr + '&VndrCOAStore=' + VndrCOAStore + '&WthTaxRate=' + WthTaxRate + '&form=fncClickSaveJDAPenalties',
					success: function(data){
						$("#btnJDASaveMall").button("reset");
						if(data == "1"){
							setTimeout(function(){
								showmodal("alert", "JDA Code successfully saved.", "fncClickCancelJDAPenaltiesFinal", null, "", null, "0");
							}, 500)
						}else if(data == "2"){
							setTimeout(function(){
								showmodal("alert", "JDA Code already exist.", "", null, "", null, "1");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", "Failed to save JDA Code.", "", null, "", null, "1");
							}, 500)
						}
					}
				})
			// }
		}
	}
</script>
<!-- PENALTIES SCRIPT -->

<!-- CHARGES SCRIPT -->
<script type="text/javascript">
	$(function(){
		$("#txtPageJDAEvents").val("1");
		fncShowJDAEvents();
		$("#txtSearchJDAEvents").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageJDAEvents").val("1");
				fncShowJDAEvents(); 
			}else if ( x == '8' ){
				if($('#txtSearchJDAEvents').val() == ""){
					$("#txtPageJDAEvents").val("1");
					fncShowJDAEvents();
				}
			}
		});
	})

	function fncShowJDAEvents(){
	    var page = $("#txtPageJDAEvents").val();
		var key = $("#txtSearchJDAEvents").val();
		$.ajax({
			type: 'POST',
			url: 'setup/jdamapping/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncShowJDAEvents',
			success: function(data){
				$("#tblrefJDAEvents").html(data);
				if(data == ""){
					$(".btnAddJDAEvents").css("display", "block");
					$("#txtJDAEventAllowAdd").val("1");
				}else{
					$(".btnAddJDAEvents").css("display", "none");
					$("#txtJDAEventAllowAdd").val("0");
				}
			}, complete: function(){
				fncClickJDAEvents();
				fncLoadJDAEventsEntries();
				fncLoadJDAEventsPageNum();
				$(".txtClearJDAEvents").val("");
			}
		})
	}

	function fncLoadJDAEventsEntries(){
	    var page = $("#txtPageJDAEvents").val();
	    var key = $("#txtSearchJDAEvents").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAEventsEntries',
	        success: function(data){
	            $("#txtEntriesJDAEvents").text(data);
	        }
	    });
	}

	function fncLoadJDAEventsPageNum(){
	    var page = $("#txtPageJDAEvents").val();
	    var key = $("#txtSearchJDAEvents").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/jdamapping/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncLoadJDAEventsPageNum',
	        success: function(data){
	            $("#ulPageJDAEvents").html(data);
	        }
	    });
	}

    function fncLoadJDAEventsPageFunc(page, pagenums){
        $(".pgnumMainCat").removeClass("active");
        $("#pgnumJDAEvents" + pagenums).addClass("active");
        $("#txtPageJDAEvents").val(page);
        fncShowJDAEvents();
    }

	function fncClickJDAEvents(){
		$("#tblrefJDAEvents tr").each(function(){
			$(this).click(function(){
				$("#tblrefJDAEvents tr").removeClass("selected");
				$(this).addClass("selected");
				var arr = $(this).attr("id").split("|");
				$("#txtJDAEventsID").val(arr[0]);
				$("#txtJDAEventsCode").val(arr[1]);
				$("#txtJDAEventsLessorMajor").val(arr[2]);
				$("#txtJDAEventsLessorMinor").val(arr[3]);
				$("#txtJDAEventsLessorCOA").val(arr[4]);
				$("#txtJDAEventsVendorMajor").val(arr[5]);
				$("#txtJDAEventsVendorMinor").val(arr[6]);
				$("#txtJDAEventsVendorCOA").val(arr[7]);
				$("#txtJDAEventsWthTax").val(arr[8]);
			})
		})
	}

	function fncClickAddJDAEvents(){
		$(".txtEditJDAEvents").removeAttr("readonly");
		$("#txtJDAEventsisVendor").prop("disabled", false);
		$("#btnEditJDAEvents").css("display", "none");
		$("#btnSavingJDAEvents").css("display", "block");
		$("#tblrefJDAEvents tr").unbind("click");
	}

	function fncClickEditJDAEvents(){
		var JDACode = $("#txtJDAEventsID").val();
		if(JDACode == ""){
			setTimeout(function(){
				showmodal("alert", "Please select event first.", "", null, "", null, "1");
			}, 500)
		}else{
			$(".txtEditJDAEvents").removeAttr("readonly");
			$("#txtJDAEventsisVendor").prop("disabled", false);
			$("#btnEditJDAEvents").css("display", "none");
			$("#btnSavingJDAEvents").css("display", "block");
			$("#tblrefJDAEvents tr").unbind("click");
		}
	}

	function fncClickCancelJDAEvents(){
		$(".txtEditJDAEvents").attr("readonly", "readonly");
		$("#txtJDAEventsisVendor").prop("disabled", true);
		$("#btnEditJDAEvents").css("display", "block");
		$("#btnSavingJDAEvents").css("display", "none");
		fncClickJDAEvents();
	}

	function fncClickCancelJDAEventsFinal(){
		$(".txtEditJDAEvents").attr("readonly", "readonly");
		$("#txtJDAEventsisVendor").prop("disabled", true);
		$("#btnEditJDAEvents").css("display", "block");
		$("#btnSavingJDAEvents").css("display", "none");
		$(".txtClearJDAEvents").val("");
		fncShowJDAEvents();
	}

	function fncClickSaveJDAEvents(){
		$("#btnJDASaveMall").button("loading");
		var EventsID = $("#txtJDAEventsID").val();
		var EventCode = $("#txtJDAEventsCode").val();
		var EventDesc = $("#txtJDAEventsDescription").val();
		var LssrMjr = $("#txtJDAEventsLessorMajor").val();
		var LssrMnr = $("#txtJDAEventsLessorMinor").val();
		var LssrCOAStore = $("#txtJDAEventsLessorCOA").val();
		var VndrMjr = $("#txtJDAEventsVendorMajor").val();
		var VndrMnr = $("#txtJDAEventsVendorMinor").val();
		var VndrCOAStore = $("#txtJDAEventsVendorCOA").val();
		var WthTaxRate = $("#txtJDAEventsWthTax").val().replace(/,/g,"");
		var AllowAdd = $("#txtJDAEventAllowAdd").val();
		if(AllowAdd == "1"){
			$.ajax({
				type: 'POST',
				url: 'setup/jdamapping/class.php',
				data: 'EventsID=' + EventsID + '&EventCode=' + EventCode + '&EventDesc=' + EventDesc + '&LssrMjr=' + LssrMjr + '&LssrMnr=' + LssrMnr + '&LssrCOAStore=' + LssrCOAStore + '&VndrMjr=' + VndrMjr + '&VndrMnr=' + VndrMnr + '&VndrCOAStore=' + VndrCOAStore + '&WthTaxRate=' + WthTaxRate + '&form=fncClickSaveJDAEvents',
				success: function(data){
					$("#btnJDASaveMall").button("reset");
					if(data == "1"){
						setTimeout(function(){
							showmodal("alert", "JDA Code successfully saved.", "fncClickCancelJDAEventsFinal", null, "", null, "0");
						}, 500)
					}else if(data == "2"){
						setTimeout(function(){
							showmodal("alert", "JDA Code already exist.", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", "Failed to save JDA Code.", "", null, "", null, "1");
						}, 500)
					}
				}
			})
		}else{
			if(EventsID == ""){
				$("#btnJDASaveMall").button("reset");
				setTimeout(function(){
					showmodal("alert", "Failed to update JDA Code", "", null, "", null, "1");
				}, 500)
			}else{
				$.ajax({
					type: 'POST',
					url: 'setup/jdamapping/class.php',
					data: 'EventsID=' + EventsID + '&EventCode=' + EventCode + '&LssrMjr=' + LssrMjr + '&LssrMnr=' + LssrMnr + '&LssrCOAStore=' + LssrCOAStore + '&VndrMjr=' + VndrMjr + '&VndrMnr=' + VndrMnr + '&VndrCOAStore=' + VndrCOAStore + '&WthTaxRate=' + WthTaxRate + '&form=fncClickSaveJDAEvents',
					success: function(data){
						$("#btnJDASaveMall").button("reset");
						if(data == "1"){
							setTimeout(function(){
								showmodal("alert", "JDA Code successfully saved.", "fncClickCancelJDAEventsFinal", null, "", null, "0");
							}, 500)
						}else if(data == "2"){
							setTimeout(function(){
								showmodal("alert", "JDA Code already exist.", "", null, "", null, "1");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", "Failed to save JDA Code.", "", null, "", null, "1");
							}, 500)
						}
					}
				})
			}
		}
	}
</script>
<!-- CHARGES SCRIPT -->