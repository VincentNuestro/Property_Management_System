<script type="text/javascript">
	$(function(){
		
        $("#txtSearchPromotionalp").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPagePromotionalp").val("1");
				fncPromotionalpList(); 
			}else if ( x == '8' ){
				if($('#txtSearchPromotionalp').val() == ""){
					$("#txtPagePromotionalp").val("1");
					fncPromotionalpList();
				}
			}
		});

		$(function(){
		// $(".btnsortdash").each(function(){
			$('.btnsortdash-promotionalp').click(function(){
				if($(this).hasClass("fa-sort-up")){
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#PromotionalpSortType").val("ASC");
					$("#PromotionalpSortBy").val(this.id);
					fncPromotionalpList();
				}
				else if($(this).hasClass("fa-sort-down")){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#PromotionalpSortType").val("DESC");
					$("#PromotionalpSortBy").val(this.id);
					fncPromotionalpList();
				}else if($(this).hasClass("fa-sort")){
					// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
					if($("#PromotionalpSortType").val() == "ASC"){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#PromotionalpSortType").val("DESC");
						$("#PromotionalpSortBy").val(this.id);
						fncPromotionalpList();
					}else{
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#PromotionalpSortType").val("ASC");
						$("#PromotionalpSortBy").val(this.id);
						fncPromotionalpList();
					}
				}
			});
		// });
		});
	})

	function fncPromotionalpList() {
		var PromotionalpSortBy = $('#PromotionalpSortBy').val();
		var PromotionalpSortType = $('#PromotionalpSortType').val();
	    var page = $("#txtPagePromotionalp").val();
		var key = $("#txtSearchPromotionalp").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_promotionalp/class.php',
			data: 'page=' + page + '&key=' + key + '&PromotionalpSortBy=' + OrganizermSortBy + '&PromotionalpSortType=' + PromotionalpSortType + '&form=fncPromotionalpList',
			success: function(data){
				// alert(data);
				if(data == ''){
					$("#tblref_Promotionalp").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_Promotionalp").html(data);
				}
			}, complete: function(){
				fncPromotionalpSelect();
				loadEntriesPromotionalp();
				loadPagePromotionalp();
			}
		})
	}

	function loadEntriesPromotionalp(){
	    var page = $("#txtPagePromotionalp").val();
	    var key = $("#txtSearchPromotionalp").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/events_promotionalp/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesPromotionalp',
	        success: function(data){
	            $("#txtEntriesPromotionalp").text(data);
	        }
	    });
	}

	function loadPagePromotionalp(){
	    var page = $("#txtPagePromotionalp").val();
	    var key = $("#txtSearchPromotionalp").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/events_promotionalp/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPagePromotionalp',
	        success: function(data){
	            $("#ulPagePromotionalp").html(data);
	        }
	    });
	}

    function fncPagePromotionalp(page, pagenums){
        $(".pgnumPromotionalp").removeClass("active");
        $("#pgPromotionalp" + pagenums).addClass("active");
        $("#txtPagePromotionalp").val(page);
        fncPromotionalpList();
    }


	function fncPromotionalpSelect(){
		$("#tblref_Promotionalp tr").each(function(){
			$(this).click(function(){
				$("#tblref_Promotionalp tr").removeClass("selected");
				$(this).addClass("selected");
				fncPromotionalpSelected(this.id);
			})
		})
	}

	function fncPromotionalpSelected(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_promotionalp/class.php',
			data: 'id=' + id + '&form=fncPromotionalpSelected',
			success: function(data) {
				var arr = data.split("|");
				$("#txtPromotionalpCode").val(id);
				$("#txtPromotionalp").val(arr[0]);
				$("#HiddenPromotionalpID").val(arr[1]);
			}
		})
	}

	function fncClickAddPromotionalp(){
		$("#tblref_Promotionalp tr").unbind("click");
		$("#tblref_Promotionalp tr").removeClass("selected");
		$("#btnMainPromotionalp").css("display", "none");
		$("#btnSavePromotionalp").css("display", "block");
		$(".refPromotionalp3").removeAttr("readonly");
		$(".refPromotionalp3").val("");
	}

	function fncCancelBtnPromotionalp(){
		fncPromotionalpList();
		$("#btnMainPromotionalp").css("display", "block");
		$("#btnSavePromotionalp").css("display", "none");
		$("#btnUpdatePromotionalp").css("display", "none");
		$(".refPromotionalp3").attr("readonly", "readonly");
		$(".refPromotionalp3").val("");
        $(".refPromotionalp3").css("border-color","#D5D5D5");
	}

	function fncSavePromotionalp(){
		var Code = $("#txtPromotionalpCode").val();
		var Promotionalp = $("#txtPromotionalp").val();
		var Count = 0;
		$(".refPromotionalp3").each(function(){
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
				url: 'setup/referentialFiles/events_promotionalp/class.php',
				data: 'Code=' + Code + '&Promotionalp=' + Promotionalp +  '&form=fncSavePromotionalp',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Promotional Paraphernalias successfully saved.", "fncCancelBtnPromotionalp", null, "", null, "0");
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

	function fncClickUpdatePromotionalp(){
		var Code = $("#txtPromotionalpCode").val();
		if(Code == ""){
			setTimeout(function(){
				showmodal("alert", "Select Organizer Materials first.", "", null, "", null, "1");
			}, 500)
		}else{
			$("#tblref_Promotionalp tr").unbind("click");
			$("#btnMainPromotionalp").css("display", "none");
			$("#btnUpdatePromotionalp").css("display", "block");
			$(".refPromotionalp3").removeAttr("readonly");
			$("#txtPromotionalpCode").removeAttr("readonly");
		}
	}

	function fncUpdatePromotionalp(){
		var PromotionalpID = $("#HiddenPromotionalpID").val();
	    var Code = $("#txtPromotionalpCode").val();
		var Promotionalp = $("#txtPromotionalp").val();
		var Count = 0;
		$(".refPromotionalp3").each(function(){
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
				url: 'setup/referentialFiles/events_promotionalp/class.php',
				data: 'Code=' + Code + '&Promotionalp=' + Promotionalp + '&PromotionalpID=' + PromotionalpID + '&form=fncUpdatePromotionalp',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Promotional Paraphernalias successfully updated.", "fncCancelBtnPromotionalp", null, "", null, "0");
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

	function fncClickDeletePromotionalp(){
	    var Code = $("#txtPromotionalpCode").val();
		var Promotionalp = $("#txtPromotionalp").val();
		if(Promotionalp == ""){
			setTimeout(function(){
				showmodal("alert", "Select Promotional Paraphernalias first.", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to delete " + Promotionalp + "?", "fncClickDeletePromotionalp2", null, "", null, "0");
			}, 500)
		}
	}

	function fncClickDeletePromotionalp2(){
		var Code = $("#HiddenPromotionalpID").val();
		var Promotionalp = $("#txtPromotionalp").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_promotionalp/class.php',
			data: 'Code=' + Code + '&form=fncClickDeletePromotionalp',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", Promotionalp + " has been deleted.", "fncCancelBtnPromotionalp", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidatePromotionalp(){
		var key = $('#txtSearchPromotionalp').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_promotionalp/class.php',
			data: 'key=' + key + '&form=AutoConsolidatePromotionalp',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of Promotional Paraphernalias successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of Promotional Paraphernalias.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>