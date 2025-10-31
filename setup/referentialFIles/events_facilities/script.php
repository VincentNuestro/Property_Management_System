<script type="text/javascript">
	$(function(){
		$("#txtFacilitiesAmount").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });
		$("#txtFacilitiesAmount").keydown(function(event) {
            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188) {
            }else{
                if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
                   event.preventDefault(); 
                }   
            }
        });
        $("#txtSearchFacilities").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageFacilities").val("1");
				fncFacilitiesList(); 
			}else if ( x == '8' ){
				if($('#txtSearchFacilities').val() == ""){
					$("#txtPageFacilities").val("1");
					fncFacilitiesList();
				}
			}
		});
		   $(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash-eventsfacilities').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#FacilitiesSortType").val("ASC");
						$("#FacilitiesSortBy").val(this.id);
						fncFacilitiesList();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#FacilitiesSortType").val("DESC");
						$("#FacilitiesSortBy").val(this.id);
						fncFacilitiesList();
					}else if($(this).hasClass("fa-sort")){
						// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#FacilitiesSortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#FacilitiesSortType").val("DESC");
							$("#FacilitiesSortBy").val(this.id);
							fncFacilitiesList();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#FacilitiesSortType").val("ASC");
							$("#FacilitiesSortBy").val(this.id);
							fncFacilitiesList();
						}
					}
				});
			// });
			});
	})

	function fncFacilitiesList() {
		var FacilitiesSortBy = $('#FacilitiesSortBy').val();
		var FacilitiesSortType = $('#FacilitiesSortType').val();
	    var page = $("#txtPageFacilities").val();
		var key = $("#txtSearchFacilities").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_facilities/class.php',
			data: 'page=' + page + '&key=' + key + '&FacilitiesSortBy=' + FacilitiesSortBy + '&FacilitiesSortType=' + FacilitiesSortType + '&form=fncFacilitiesList',
			success: function(data){
				if(data == ''){
					$("#tblref_Facilities").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_Facilities").html(data);
				}
			}, complete: function(){
				fncFacilitiesSelect();
				loadEntriesFacilities();
				loadPageFacilities();
			}
		})
	}

	function loadEntriesFacilities(){
	    var page = $("#txtPageFacilities").val();
	    var key = $("#txtSearchFacilities").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/events_facilities/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesFacilities',
	        success: function(data){
	            $("#txtEntriesFacilities").text(data);
	        }
	    });
	}

	function loadPageFacilities(){
	    var page = $("#txtPageFacilities").val();
	    var key = $("#txtSearchFacilities").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/events_facilities/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageFacilities',
	        success: function(data){
	            $("#ulPageFacilities").html(data);
	        }
	    });
	}

    function fncPageFacilities(page, pagenums){
        $(".pgnumFacilities").removeClass("active");
        $("#pgFacilities" + pagenums).addClass("active");
        $("#txtPageFacilities").val(page);
        fncFacilitiesList();
    }


	function fncFacilitiesSelect(){
		$("#tblref_Facilities tr").each(function(){
			$(this).click(function(){
				$("#tblref_Facilities tr").removeClass("selected");
				$(this).addClass("selected");
				fncFacilitiesSelected(this.id);
			})
		})
	}

	function fncFacilitiesSelected(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_facilities/class.php',
			data: 'id=' + id + '&form=fncFacilitiesSelected',
			success: function(data) {
				var arr = data.split("|");
				$("#txtFacilitiesCode").val(id);
				$("#txtFacilities").val(arr[0]);
				$("#txtFacilitiesAmount").val(arr[1]);
				$("#HiddenFacilitiesID").val(arr[2]);
			}
		})
	}

	function fncClickAddFacilities(){
		$("#tblref_Facilities tr").unbind("click");
		$("#tblref_Facilities tr").removeClass("selected");
		$("#btnMainFacilities").css("display", "none");
		$("#btnSaveFacilities").css("display", "block");
		$(".refFacilities3").removeAttr("readonly");
		$(".refFacilities3").val("");
	}

	function fncCancelBtnFacilities(){
		fncFacilitiesList();
		$("#btnMainFacilities").css("display", "block");
		$("#btnSaveFacilities").css("display", "none");
		$("#btnUpdateFacilities").css("display", "none");
		$(".refFacilities3").attr("readonly", "readonly");
		$(".refFacilities3").val("");
        $(".refFacilities3").css("border-color","#D5D5D5");
	}

	function fncSaveFacilities(){
		var Code = $("#txtFacilitiesCode").val();
		var Facilities = $("#txtFacilities").val();
		var Amount = $("#txtFacilitiesAmount").val().replace(/,/g,"");
		var Count = 0;
		$(".refFacilities3").each(function(){
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
				url: 'setup/referentialFiles/events_facilities/class.php',
				data: 'Code=' + Code + '&Facilities=' + Facilities + '&Amount=' + Amount + '&form=fncSaveFacilities',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Facilities successfully saved.", "fncCancelBtnFacilities", null, "", null, "0");
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

	function fncClickUpdateFacilities(){
		var Code = $("#txtFacilitiesCode").val();
		if(Code == ""){
			setTimeout(function(){
				showmodal("alert", "Select facilities first.", "", null, "", null, "1");
			}, 500)
		}else{
			$("#tblref_Facilities tr").unbind("click");
			$("#btnMainFacilities").css("display", "none");
			$("#btnUpdateFacilities").css("display", "block");
			$(".refFacilities3").removeAttr("readonly");
			$("#txtFacilitiesCode").removeAttr("readonly");
		}
	}

	function fncUpdateFacilities(){
		var FacilitiesID = $("#HiddenFacilitiesID").val();
	    var Code = $("#txtFacilitiesCode").val();
		var Facilities = $("#txtFacilities").val();
		var Amount = $("#txtFacilitiesAmount").val().replace(/,/g,"");
		var Count = 0;
		$(".refFacilities3").each(function(){
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
				url: 'setup/referentialFiles/events_facilities/class.php',
				data: 'Code=' + Code + '&Facilities=' + Facilities + '&Amount=' + Amount + '&FacilitiesID=' + FacilitiesID + '&form=fncUpdateFacilities',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Facilities successfully updated.", "fncCancelBtnFacilities", null, "", null, "0");
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

	function fncClickDeleteFacilities(){
	    var Code = $("#txtFacilitiesCode").val();
		var Facilities = $("#txtFacilities").val();
		if(Facilities == ""){
			setTimeout(function(){
				showmodal("alert", "Select facilities first.", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to delete " + Facilities + "?", "fncClickDeleteFacilities2", null, "", null, "0");
			}, 500)
		}
	}

	function fncClickDeleteFacilities2(){
		var Code = $("#HiddenFacilitiesID").val();
		var Facilities = $("#txtFacilities").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_facilities/class.php',
			data: 'Code=' + Code + '&form=fncClickDeleteFacilities',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", Facilities + " has been deleted.", "fncCancelBtnFacilities", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidateFacilities(){
		var key = $('#txtSearchPenalty').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_facilities/class.php',
			data: 'key=' + key + '&form=AutoConsolidateFacilities',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of facilities successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of facilities.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>