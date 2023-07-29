<script type="text/javascript">
	$(function(){
		$("#txtsearchreq").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageRequirements").val("1");
				displayReq(); 
			}else if ( x == '8' ){
				if($('#txtsearchreq').val() == ""){
					$("#txtPageRequirements").val("1");
					displayReq();
				}
			}
		});

		$(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash-unitreq').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#RequirementsSortType").val("ASC");
						$("#RequirementsSortBy").val(this.id);
						displayReq();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#RequirementsSortType").val("DESC");
						$("#RequirementsSortBy").val(this.id);
						displayReq();
					}else if($(this).hasClass("fa-sort")){
						// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#RequirementsSortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#RequirementsSortType").val("DESC");
							$("#RequirementsSortBy").val(this.id);
							displayReq();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#RequirementsSortType").val("ASC");
							$("#RequirementsSortBy").val(this.id);
							displayReq();
						}
					}
				});
			// });
		});
	});

	function displayReq(){
		var RequirementsSortBy = $('#RequirementsSortBy').val();
		var RequirementsSortType = $('#RequirementsSortType').val();
	    var page = $("#txtPageRequirements").val();
		var key = $("#txtsearchreq").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_req/class.php',
			data: 'page=' + page + '&key=' + key + '&RequirementsSortBy=' + RequirementsSortBy + '&RequirementsSortType=' + RequirementsSortType + '&form=displayReq',
			success: function(data) {
				if(data == ''){
					$("#tblref_applicationrequirements").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_applicationrequirements").html(data);
				}
			}, complete: function(){
				reqSelected();
				loadEntriesRequirements();
				loadPageRequirements();
			}
		})
	}

	function loadEntriesRequirements(){
	    var page = $("#txtPageRequirements").val();
	    var key = $("#txtsearchreq").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_req/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesRequirements',
	        success: function(data){
	            $("#txtEntriesRequirements").text(data);
	        }
	    });
	}

	function loadPageRequirements(){
	    var page = $("#txtPageRequirements").val();
	    var key = $("#txtsearchreq").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_req/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageRequirements',
	        success: function(data){
	            $("#ulPageRequirements").html(data);
	        }
	    });
	}

    function fncPageRequirements(page, pagenums){
        $(".pgnumRequirements").removeClass("active");
        $("#pgRequirements" + pagenums).addClass("active");
        $("#txtPageRequirements").val(page);
        displayReq();
    }

	function reqSelected(){
		$("#tblref_applicationrequirements tr").each(function(){
			$(this).click(function(){
				$("#tblref_applicationrequirements tr").removeClass("selected");
				$(this).addClass("selected");
				selectedReq(this.id);
			})
		})
	}

	function selectedReq(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_req/class.php',
			data: 'id=' + id + '&form=selectedReq',
			success: function(data) {
				var arr = data.split("|");
				$("#hiddenreqid").val(arr[0]);
				$("#reqDesc").val(arr[1]);
				$(".override").each(function(){
		            if($(this).val() == arr[2]){ 
		            	$(this).prop("checked", true); 
		            }
		        });
		        $("#reqCode").val(arr[3]);
			}
		})
	}

	function clickAddReq(){
		$("#tblref_applicationrequirements tr").unbind("click");
		$("#tblref_applicationrequirements tr").removeClass("selected");
		$("#buttonsReq").css("display", "none");
		$("#savingbuttonsReq").css("display", "block");
		$(".txtReq").removeAttr("readonly");
		$(".txtReq").val("");
		$(".override").prop("disabled", false);
	}

	function cancelbuttonReq(){
		displayReq();
		$("#buttonsReq").css("display", "block");
		$("#savingbuttonsReq").css("display", "none");
		$("#updatebuttonsReq").css("display", "none");
		$(".txtReq").attr("readonly", "readonly");
		$(".txtReq").val("");
		$(".override").prop("disabled", true);
        $(".txtReq").css("border-color","#D5D5D5");
	}

	function saveReq(){
		var reqDesc = $("#reqDesc").val();
		var reqCode = $("#reqCode").val();
		var override = "";
	    $(".override").each(function(){
	        if($(this).is(":checked") == true){
	          	override = this.value;
	        }
	    });
	    var Count = 0;
		$(".txtReq").each(function(){
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
				url: 'setup/referentialFiles/unit_req/class.php',
				data: 'reqDesc=' + reqDesc + '&reqCode=' + reqCode + '&override=' + override + '&form=saveReq',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Requirement successfully saved.", "cancelbuttonReq", null, "", null, "0");
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

	function clickUpdateReq() {
		var hiddenreqid = $("#hiddenreqid").val();
		var reqDesc = $("#reqDesc").val();
		if(reqDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select description first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/unit_req/class.php',
				data: 'hiddenreqid=' + hiddenreqid + '&form=clickUpdateReq',
				success: function(data){
					if(data == "1"){
						$("#tblref_applicationrequirements tr").unbind("click");
						$("#buttonsReq").css("display", "none");
						$("#updatebuttonsReq").css("display", "block");
						$("#reqCode").attr("readonly", "readonly");
						$("#reqDesc").removeAttr("readonly");
						$(".override").prop("disabled", false);
					}else{
						$("#tblref_applicationrequirements tr").unbind("click");
						$("#buttonsReq").css("display", "none");
						$("#updatebuttonsReq").css("display", "block");
						$(".txtReq").removeAttr("readonly");
						$(".override").prop("disabled", false);
					}
				}
			})
		}
	}

	function updateReq() {
		var hiddenreqid = $("#hiddenreqid").val();
		var reqDesc = $("#reqDesc").val();
		var reqCode = $("#reqCode").val();
		var override = "";
	    $(".override").each(function(){
	        if($(this).is(":checked") == true){
	          	override = this.value;
	        }
	    });
		var Count = 0;
		$(".txtReq").each(function(){
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
				url: 'setup/referentialFiles/unit_req/class.php',
				data: 'hiddenreqid=' + hiddenreqid + '&reqDesc=' + reqDesc + '&override=' + override + '&reqCode=' + reqCode + '&form=updateReq',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Requirement successfully updated.", "cancelbuttonReq", null, "", null, "0");
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

	function clickDeleteReq() {
		var reqDesc = $("#reqDesc").val();
		if(reqDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select description first", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to delete " + reqDesc, "clickDeleteReq2", null, "", null, "0");
			}, 500)
		}
	}

	function clickDeleteReq2(){
		var reqDesc = $("#reqDesc").val();
		var hiddenreqid = $("#hiddenreqid").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_req/class.php',
			data: 'hiddenreqid=' + hiddenreqid + '&form=deleteReq',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", reqDesc + " has been deleted.", "cancelbuttonReq", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidateReq(){
		var key = $('#txtsearchreq').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_req/class.php',
			data: 'key=' + key + '&form=AutoConsolidateReq',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of requirement successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of requirement.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>