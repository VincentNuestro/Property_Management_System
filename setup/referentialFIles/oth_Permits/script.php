<script type="text/javascript">
	$(function(){
		$("#txtsearchTOP").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPagePermits").val("1");
				displayListofTypes(); 
			}else if ( x == '8' ){
				if($('#txtsearchTOP').val() == ""){
					$("#txtPagePermits").val("1");
					displayListofTypes();
				}
			}
		});

			$(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash-permits').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#PermitsSortType").val("ASC");
						$("#PermitsSortBy").val(this.id);
						displayListofTypes();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#PermitsSortType").val("DESC");
						$("#PermitsSortBy").val(this.id);
						displayListofTypes();
					}else if($(this).hasClass("fa-sort")){
						// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#PermitsSortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#PermitsSortType").val("DESC");
							$("#PermitsSortBy").val(this.id);
							displayListofTypes();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#PermitsSortType").val("ASC");
							$("#PermitsSortBy").val(this.id);
							displayListofTypes();
						}
					}
				});
			// });
		});
	});

	function displayListofTypes() {
		var PermitsSortBy = $('#PermitsSortBy').val();
		var PermitsSortType = $('#PermitsSortType').val();
		var key = $("#txtsearchTOP").val();
	    var page = $("#txtPagePermits").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_Permits/class.php',
			data: 'page=' + page + '&key=' + key + '&PermitsSortBy=' + PermitsSortBy + '&PermitsSortType=' + PermitsSortType + '&form=displayListofTypes',
			success: function(data){
				if(data == ''){
					$("#tblref_typeofpermits").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_typeofpermits").html(data);
				}
			}, complete: function(){
				TOPSelected();
				loadEntriesPermits();
				loadPagePermits();
			}
		})
	}

	function loadEntriesPermits(){
	    var page = $("#txtPagePermits").val();
	    var key = $("#txtsearchTOP").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/oth_Permits/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesPermits',
	        success: function(data){
	            $("#txtEntriesPermits").text(data);
	        }
	    });
	}

	function loadPagePermits(){
	    var page = $("#txtPagePermits").val();
	    var key = $("#txtsearchTOP").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/oth_Permits/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPagePermits',
	        success: function(data){
	            $("#ulPagePermits").html(data);
	        }
	    });
	}

    function fncPagePermits(page, pagenums){
        $(".pgnumPermits").removeClass("active");
        $("#pgPermits" + pagenums).addClass("active");
        $("#txtPagePermits").val(page);
        displayListofTypes();
    }

	function TOPSelected(){
		$("#tblref_typeofpermits tr").each(function(){
			$(this).click(function(){
				$("#tblref_typeofpermits tr").removeClass("selected");
				$(this).addClass("selected");
				selectedTOP(this.id);
			})
		})
	}

	function selectedTOP(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_Permits/class.php',
			data: 'id=' + id + '&form=selectedTOP',
			success: function(data) {
				var arr = data.split("|");
				$("#hiddenTOPID").val(arr[0]);
				$("#PermitDesc").val(arr[1]);
				$(".overridepermit").each(function(){
		            if($(this).val() == arr[2]){ 
		            	$(this).prop("checked", true); 
		            }
		        });
		        $("#PermitCode").val(arr[3]);
			}
		})
	}

	function clickAddtypeofpermits(){
		$("#tblref_typeofpermits tr").unbind("click");
		$("#tblref_typeofpermits tr").removeClass("selected");
		$("#buttonstypeofpermits").css("display", "none");
		$("#savingbuttonstypeofpermits").css("display", "block");
		$(".TypeofPermit").removeAttr("readonly");
		$(".TypeofPermit").val("");
		$(".overridepermit").prop("disabled", false);
	}

	function cancelbuttontypeofpermits(){
		displayListofTypes();
		$("#buttonstypeofpermits").css("display", "block");
		$("#savingbuttonstypeofpermits").css("display", "none");
		$("#updatebuttonstypeofpermits").css("display", "none");
		$(".TypeofPermit").attr("readonly", "readonly");
		$(".TypeofPermit").val("");
		$(".overridepermit").prop("disabled", true);
        $(".TypeofPermit").css("border-color","#D5D5D5");
	}

	function saveTypeOfPermit(){
		var PermitDesc = $("#PermitDesc").val();
		var PermitCode = $("#PermitCode").val();
		var override = "";
	    $(".overridepermit").each(function(){
	        if($(this).is(":checked") == true){
	          	override = this.value;
	        }
	    });
		var Count = 0;
		$(".TypeofPermit").each(function(){
			if($(this).val() == ""){
                $(this).css("border-color","#f2a696");
                Count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
		})
		if(Count == 0){	
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/oth_Permits/class.php',
				data: 'override=' + override + '&PermitDesc=' + PermitDesc + '&PermitCode=' + PermitCode + '&form=saveTypeOfPermit',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Permit successfully saved.", "cancelbuttontypeofpermits", null, "", null, "0");
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

	function clickUpdatetypeofpermits() {
		var PermitDesc = $("#PermitDesc").val();
		var hiddenTOPID = $("#hiddenTOPID").val();
		if(PermitDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select type of permit first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/oth_Permits/class.php',
				data: 'hiddenTOPID=' + hiddenTOPID + '&form=clickUpdatetypeofpermits',
				success: function(data){
					if(data == "1"){
						$("#tblref_typeofpermits tr").unbind("click");
						$("#buttonstypeofpermits").css("display", "none");
						$("#updatebuttonstypeofpermits").css("display", "block");
						$("#PermitCode").attr("readonly", "readonly");
						$("#PermitDesc").removeAttr("readonly");
						$(".overridepermit").prop("disabled", false);
					}else{
						$("#tblref_typeofpermits tr").unbind("click");
						$("#buttonstypeofpermits").css("display", "none");
						$("#updatebuttonstypeofpermits").css("display", "block");
						$(".TypeofPermit").removeAttr("readonly");
						$(".overridepermit").prop("disabled", false);
					}
				}
			})
		}
	}

	function updatetypeofpermits() {
		var hiddenTOPID = $("#hiddenTOPID").val();
		var PermitDesc = $("#PermitDesc").val();
		var PermitCode = $("#PermitCode").val();
		var override = "";
		$(".overridepermit").each(function(){
	        if($(this).is(":checked") == true){
	          	override = this.value;
	        }
	    });
		var Count = 0;
		$(".TypeofPermit").each(function(){
			if($(this).val() == ""){
                $(this).css("border-color","#f2a696");
                Count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
		})
		if(Count == 0){	
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/oth_Permits/class.php',
				data: 'override=' + override + '&hiddenTOPID=' + hiddenTOPID + '&PermitDesc=' + PermitDesc + '&PermitCode=' + PermitCode + '&form=updatetypeofpermits',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Permit successfully updated.", "cancelbuttontypeofpermits", null, "", null, "0");
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

	function clickDeletetypeofpermits() {
		var PermitDesc = $("#PermitDesc").val();
		var hiddenTOPID = $("#hiddenTOPID").val();
		if(PermitDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select type of permit first", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to delete " + PermitDesc, "clickDeletetypeofpermits2", null, "", null, "0");
			}, 500)
		}
	}

	function clickDeletetypeofpermits2(){
		var PermitDesc = $("#PermitDesc").val();
		var hiddenTOPID = $("#hiddenTOPID").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_Permits/class.php',
			data: 'hiddenTOPID=' + hiddenTOPID + '&form=deletetypeofpermits',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", PermitDesc + " has been deleted.", "cancelbuttontypeofpermits", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidatePermits(){
		var key = $('#txtsearchunitclass').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_Permits/class.php',
			data: 'key=' + key + '&form=AutoConsolidatePermits',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of permit successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of permit.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>