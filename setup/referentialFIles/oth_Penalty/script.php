<script type="text/javascript">
	$(function(){
		$("#txtPenaltyAmount").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });
		$("#txtPenaltyAmount").keydown(function(event) {
            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188) {
            }else{
                if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
                   event.preventDefault(); 
                }   
            }
        });
        $("#txtSearchPenalty").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPagePenalty").val("1");
				fncPenaltyList(); 
			}else if ( x == '8' ){
				if($('#txtSearchPenalty').val() == ""){
					$("#txtPagePenalty").val("1");
					fncPenaltyList();
				}
			}
		});
	        $(function(){
				$('.btnsortdash-othpenalty').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#othPenaltySortType").val("ASC");
						$("#othPenaltySortBy").val(this.id);
						fncPenaltyList();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#othPenaltySortType").val("DESC");
						$("#othPenaltySortBy").val(this.id);
						fncPenaltyList();
					}else if($(this).hasClass("fa-sort")){
						if($("#othPenaltySortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#othPenaltySortType").val("DESC");
							$("#othPenaltySortBy").val(this.id);
							fncPenaltyList();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#othPenaltySortType").val("ASC");
							$("#othPenaltySortBy").val(this.id);
							fncPenaltyList();
						}
					}
				});
			});
	})

	function fncPenaltyList() {
		var othPenaltySortBy = $('#othPenaltySortBy').val();
		var othPenaltySortType = $('#othPenaltySortType').val();
	    var page = $("#txtPagePenalty").val();
		var key = $("#txtSearchPenalty").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_Penalty/class.php',
			data: 'page=' + page + '&key=' + key +  '&othPenaltySortBy=' + othPenaltySortBy + '&othPenaltySortType=' + othPenaltySortType +  '&form=fncPenaltyList',
			success: function(data){
				if(data == ''){
					$("#tblref_Penalty").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_Penalty").html(data);
				}
			}, complete: function(){
				fncPenaltySelect();
				loadEntriesPenalty();
				loadPagePenalty();
			}
		})
	}

	function loadEntriesPenalty(){
	    var page = $("#txtPagePenalty").val();
	    var key = $("#txtSearchPenalty").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/oth_Penalty/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesPenalty',
	        success: function(data){
	            $("#txtEntriesPenalty").text(data);
	        }
	    });
	}

	function loadPagePenalty(){
	    var page = $("#txtPagePenalty").val();
	    var key = $("#txtSearchPenalty").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/oth_Penalty/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPagePenalty',
	        success: function(data){
	            $("#ulPagePenalty").html(data);
	        }
	    });
	}

    function fncPagePenalty(page, pagenums){
        $(".pgnumPenalty").removeClass("active");
        $("#pgPenalty" + pagenums).addClass("active");
        $("#txtPagePenalty").val(page);
        fncPenaltyList();
    }


	function fncPenaltySelect(){
		$("#tblref_Penalty tr").each(function(){
			$(this).click(function(){
				$("#tblref_Penalty tr").removeClass("selected");
				$(this).addClass("selected");
				fncPenaltySelected(this.id);
			})
		})
	}

	function fncPenaltySelected(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_Penalty/class.php',
			data: 'id=' + id + '&form=fncPenaltySelected',
			success: function(data) {
				var arr = data.split("|");
				$("#txtPenaltyCode").val(id);
				$("#txtPenalty").val(arr[0]);
				$("#txtPenaltyAmount").val(arr[1]);
				$("#HiddenPenaltyID").val(arr[2]);
			}
		})
	}

	function fncClickAddPenalty(){
		$("#tblref_Penalty tr").unbind("click");
		$("#tblref_Penalty tr").removeClass("selected");
		$("#btnMainPenalty").css("display", "none");
		$("#btnSavePenalty").css("display", "block");
		$(".refPenalty3").removeAttr("readonly");
		$(".refPenalty3").val("");
	}

	function fncCancelBtnPenalty(){
		fncPenaltyList();
		$("#btnMainPenalty").css("display", "block");
		$("#btnSavePenalty").css("display", "none");
		$(".refPenalty3").attr("readonly", "readonly");
		$(".refPenalty3").val("");
	}

	function fncCancelBtnPenalty2(){
		fncPenaltyList();
		$("#btnMainPenalty").css("display", "block");
		$("#btnUpdatePenalty").css("display", "none");
		$(".refPenalty3").attr("readonly", "readonly");
		$(".refPenalty3").val("");
	}

	function fncSavePenalty(){
		var Code = $("#txtPenaltyCode").val();
		var Penalty = $("#txtPenalty").val();
		var Amount = $("#txtPenaltyAmount").val().replace(/,/g,"");
		var count = 0;
		$(".refPenalty3").each(function(){
			if($(this).val() == ""){
				count++;
			}
			$(this).attr("id");
		})
		if(count == 0){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/oth_Penalty/class.php',
				data: 'Code=' + Code + '&Penalty=' + Penalty + '&Amount=' + Amount + '&form=fncSavePenalty',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Penalty successfully saved.", "fncCancelBtnPenalty", null, "", null, "0");
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
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncClickUpdatePenalty(){
		var Code = $("#txtPenaltyCode").val();
		if(Code == ""){
			setTimeout(function(){
				showmodal("alert", "Select penalty first.", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/oth_Penalty/class.php',
				data: 'Code=' + Code + '&form=fncClickUpdatePenalty',
				success:function(data){
					if(data == 0){
						$("#tblref_Penalty tr").unbind("click");
						$("#btnMainPenalty").css("display", "none");
						$("#btnUpdatePenalty").css("display", "block");
						$(".refPenalty2").removeAttr("readonly");
						$("#txtPenaltyCode").removeAttr("readonly");
					}else{
						$("#tblref_Penalty tr").unbind("click");
						$("#btnMainPenalty").css("display", "none");
						$("#btnUpdatePenalty").css("display", "block");
						$(".refPenalty2").removeAttr("readonly");
						$("#txtPenaltyCode").attr("readonly", "readonly");
					}
				}
			})
		}
	}

	function fncUpdatePenalty(){
		var PenaltyID = $("#HiddenPenaltyID").val();
	    var Code = $("#txtPenaltyCode").val();
		var Penalty = $("#txtPenalty").val();
		var Amount = $("#txtPenaltyAmount").val().replace(/,/g,"");
		var count = 0;
		$(".refPenalty3").each(function(){
			if($(this).val() == ""){
				count++;
			}
		})
		if(count == 0){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/oth_Penalty/class.php',
				data: 'Code=' + Code + '&Penalty=' + Penalty + '&Amount=' + Amount + '&PenaltyID=' + PenaltyID + '&form=fncUpdatePenalty',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Penalty successfully updated.", "fncCancelBtnPenalty2", null, "", null, "0");
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
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncClickDeletePenalty(){
	    var Code = $("#txtPenaltyCode").val();
		var Penalty = $("#txtPenalty").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/oth_Penalty/class.php',
			data: 'Code=' + Code + '&form=fncClickUpdatePenalty',
			success:function(data){
				if(data == 0){
					if(Penalty == ""){
						setTimeout(function(){
							showmodal("alert", "Select penalty first.", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("confirm", "Are you sure you want to delete " + Penalty + "?", "fncClickDeletePenalty2", null, "", null, "0");
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

	function fncClickDeletePenalty2(){
		var Code = $("#HiddenPenaltyID").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_Penalty/class.php',
			data: 'Code=' + Code + '&form=fncClickDeletePenalty',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", Code + " has been deleted.", "fncPenaltyList", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidatePenalty(){
		var key = $('#txtSearchPenalty').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_Penalty/class.php',
			data: 'key=' + key + '&form=AutoConsolidatePenalty',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of penalty successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of penalty.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>