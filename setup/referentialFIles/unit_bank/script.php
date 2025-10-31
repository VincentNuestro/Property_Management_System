<script type="text/javascript">
	$(function(){
		$("#txtsearchbank").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageBank").val("1");
				displayBank(); 
			}else if ( x == '8' ){
				if($('#txtsearchbank').val() == ""){
					$("#txtPageBank").val("1");
					displayBank();
				}
			}
		});
		$(function(){
			$('.btnsortdash-unitbank').click(function(){
				if($(this).hasClass("fa-sort-up")){
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#unitBankSortType").val("ASC");
					$("#unitBankSortBy").val(this.id);
					displayBank();
				}
				else if($(this).hasClass("fa-sort-down")){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#unitBankSortType").val("DESC");
					$("#unitBankSortBy").val(this.id);
					displayBank();
				}else if($(this).hasClass("fa-sort")){
					if($("#ManpowerSortType").val() == "ASC"){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#unitBankSortType").val("DESC");
						$("#unitBankSortBy").val(this.id);
						displayBank();
					}else{
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#unitBankSortType").val("ASC");
						$("#unitBankSortBy").val(this.id);
						displayBank();
					}
				}
			});
		});
	});
	
	function displayBank(){
		var unitBankSortBy = $('#unitBankSortBy').val();
		var unitBankSortType = $('#unitBankSortType').val();
	    var page = $("#txtPageBank").val();
		var key = $("#txtsearchbank").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_bank/class.php',
			data: 'page=' + page + '&key=' + key + '&unitBankSortBy=' + unitBankSortBy + '&unitBankSortType=' + unitBankSortType + '&form=displayBank',
			success: function(data){
				if(data == ''){
					$("#tblrefbank").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblrefbank").html(data);
				}
			}, complete: function(){
				bankSelected();
				loadEntriesBank();
				loadPageBank();
			}
		})
	}

	function loadEntriesBank(){
	    var page = $("#txtPageBank").val();
	    var key = $("#txtsearchbank").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_bank/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesBank',
	        success: function(data){
	            $("#txtEntriesBank").text(data);
	        }
	    });
	}

	function loadPageBank(){
	    var page = $("#txtPageBank").val();
	    var key = $("#txtsearchbank").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_bank/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageBank',
	        success: function(data){
	            $("#ulPageBank").html(data);
	        }
	    });
	}

    function fncPageBank(page, pagenums){
        $(".pgnumBank").removeClass("active");
        $("#pgBank" + pagenums).addClass("active");
        $("#txtPageBank").val(page);
        displayBank();
    }

	function bankSelected(){
		$("#tblrefbank tr").each(function(){
			$(this).click(function(){
				$("#tblrefbank tr").removeClass("selected");
				$(this).addClass("selected");
				selectedBank(this.id);
			})
		})
	}

	function selectedBank(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_bank/class.php',
			data: 'id=' + id + '&form=selectedBank',
			success: function(data){
				var arr = data.split("|");
				$("#bankCode").val(arr[0]);
				$("#bankDesc").val(arr[1]);
				$("#hiddenbankid").val(arr[2]);
			}
		})
	}

	function clickAddBank(){
		$("#tblrefbank tr").unbind("click");
		$("#tblrefbank tr").removeClass("selected");
		$("#buttonsBank").css("display", "none");
		$("#savingbuttonsBank").css("display", "block");
		$(".txtBank").removeAttr("readonly");
		$(".txtBank").val("");
	}

	function cancelbuttonBank(){
		displayBank();
		$("#buttonsBank").css("display", "block");
		$("#savingbuttonsBank").css("display", "none");
		$(".txtBank").attr("readonly", "readonly");
		$(".txtBank").val("");
	}

	function cancelbuttonBank2(){
		displayBank();
		$("#buttonsBank").css("display", "block");
		$("#updatebuttonsBank").css("display", "none");
		$(".txtBank").attr("readonly", "readonly");
	}

	function saveBank(){
		var bankCode = $("#bankCode").val();
		var bankDesc = $("#bankDesc").val();
		if($("#bankCode").val() != "" && $("#bankDesc").val() != ""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/unit_bank/class.php',
				data: 'bankCode=' + bankCode + '&bankDesc=' + bankDesc + '&form=saveBank',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Bank Name successfully saved.", "cancelbuttonBank", null, "", null, "0");
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

	function clickUpdateBank(){
		var bankCode = $("#bankCode").val();
		if(bankCode == ""){
			setTimeout(function(){
				showmodal("alert", "Select bank first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/unit_bank/class.php',
				data: 'bankCode=' + bankCode + '&form=clickUpdateBank',
				success: function(data){
					if(data == 0){
						$("#tblrefbank tr").unbind("click");
						$("#buttonsBank").css("display", "none");
						$("#updatebuttonsBank").css("display", "block");
						$(".txtBank").removeAttr("readonly");
						$("#bankCode").removeAttr("readonly");
					}else{
						$("#tblrefbank tr").unbind("click");
						$("#buttonsBank").css("display", "none");
						$("#updatebuttonsBank").css("display", "block");
						$(".txtBank").removeAttr("readonly");
						$("#bankCode").attr("readonly", "readonly");
					}
				}
			})
		}
	}

	function updateBank() {
		var hiddenbankid = $("#hiddenbankid").val();
		var bankCode = $("#bankCode").val();
		var bankDesc = $("#bankDesc").val();
		if($("#bankCode").val() != "" && $("#bankDesc").val() != ""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/unit_bank/class.php',
				data: 'hiddenbankid=' + hiddenbankid + '&bankCode=' + bankCode + '&bankDesc=' + bankDesc + '&form=updateBank',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Bank Name successfully updated.", "cancelbuttonBank2", null, "", null, "0");
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

	function clickDeleteBank() {
		var bankCode = $("#bankCode").val();
		var bankDesc = $("#bankDesc").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/unit_bank/class.php',
			data: 'bankCode=' + bankCode + '&form=clickUpdateBank',
			success: function(data){
				if(data == 0){
					if(bankCode == ""){
						setTimeout(function(){
							showmodal("alert", "Select bank first", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("confirm", "Are you sure you want to delete " + bankDesc, "clickDeleteBank2", null, "", null, "0");
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

	function clickDeleteBank2(){
		var bankCode = $("#bankCode").val();
		var bankDesc = $("#bankDesc").val();
		var hiddenbankid = $("#hiddenbankid").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_bank/class.php',
			data: 'hiddenbankid=' + hiddenbankid + '&form=deleteBank',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", bankDesc + " has been deleted.", "displayBank", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidateBank(){
		var key = $('#txtsearchbank').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_bank/class.php',
			data: 'key=' + key + '&form=AutoConsolidateBank',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of bank successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of bank.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>