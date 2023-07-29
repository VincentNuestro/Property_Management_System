<script type="text/javascript">
	$(function(){
		
        $("#txtSearchOrganizerm").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageOrganizerm").val("1");
				fncOrganizermList(); 
			}else if ( x == '8' ){
				if($('#txtSearchOrganizerm').val() == ""){
					$("#txtPageOrganizerm").val("1");
					fncOrganizermList();
				}
			}
		});

		$(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash-organizerm').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#OrganizermSortType").val("ASC");
						$("#OrganizermSortBy").val(this.id);
						fncOrganizermList();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#OrganizermSortType").val("DESC");
						$("#OrganizermSortBy").val(this.id);
						fncOrganizermList();
					}else if($(this).hasClass("fa-sort")){
						// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#OrganizermSortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#OrganizermSortType").val("DESC");
							$("#OrganizermSortBy").val(this.id);
							fncOrganizermList();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#OrganizermSortType").val("ASC");
							$("#OrganizermSortBy").val(this.id);
							fncOrganizermList();
						}
					}
				});
			// });
			});
	})

	function fncOrganizermList() {
		var OrganizermSortBy = $('#OrganizermSortBy').val();
		var OrganizermSortType = $('#OrganizermSortType').val();
	    var page = $("#txtPageOrganizerm").val();
		var key = $("#txtSearchOrganizerm").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_organizerm/class.php',
			data: 'page=' + page + '&key=' + key + '&OrganizermSortBy=' + OrganizermSortBy + '&OrganizermSortType=' + OrganizermSortType + '&form=fncOrganizermList',
			success: function(data){
				if(data == ''){
					$("#tblref_Organizerm").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_Organizerm").html(data);
				}
			}, complete: function(){
				fncOrganizermSelect();
				loadEntriesOrganizerm();
				loadPageOrganizerm();
			}
		})
	}

	function loadEntriesOrganizerm(){
	    var page = $("#txtPageOrganizerm").val();
	    var key = $("#txtSearchOrganizerm").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/events_organizerm/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesOrganizerm',
	        success: function(data){
	            $("#txtEntriesOrganizerm").text(data);
	        }
	    });
	}

	function loadPageOrganizerm(){
	    var page = $("#txtPageOrganizerm").val();
	    var key = $("#txtSearchOrganizerm").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/events_organizerm/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageOrganizerm',
	        success: function(data){
	            $("#ulPageOrganizerm").html(data);
	        }
	    });
	}

    function fncPageOrganizerm(page, pagenums){
        $(".pgnumOrganizerm").removeClass("active");
        $("#pgOrganizerm" + pagenums).addClass("active");
        $("#txtPageOrganizerm").val(page);
        fncOrganizermList();
    }


	function fncOrganizermSelect(){
		$("#tblref_Organizerm tr").each(function(){
			$(this).click(function(){
				$("#tblref_Organizerm tr").removeClass("selected");
				$(this).addClass("selected");
				fncOrganizermSelected(this.id);
			})
		})
	}

	function fncOrganizermSelected(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_organizerm/class.php',
			data: 'id=' + id + '&form=fncOrganizermSelected',
			success: function(data) {
				var arr = data.split("|");
				$("#txtOrganizermCode").val(id);
				$("#txtOrganizerm").val(arr[0]);
				$("#HiddenOrganizermID").val(arr[1]);
			}
		})
	}

	function fncClickAddOrganizerm(){
		$("#tblref_Organizerm tr").unbind("click");
		$("#tblref_Organizerm tr").removeClass("selected");
		$("#btnMainOrganizerm").css("display", "none");
		$("#btnSaveOrganizerm").css("display", "block");
		$(".refOrganizerm3").removeAttr("readonly");
		$(".refOrganizerm3").val("");
	}

	function fncCancelBtnOrganizerm(){
		fncOrganizermList();
		$("#btnMainOrganizerm").css("display", "block");
		$("#btnSaveOrganizerm").css("display", "none");
		$("#btnUpdateOrganizerm").css("display", "none");
		$(".refOrganizerm3").attr("readonly", "readonly");
		$(".refOrganizerm3").val("");
        $(".refOrganizerm3").css("border-color","#D5D5D5");
	}

	function fncSaveOrganizerm(){
		var Code = $("#txtOrganizermCode").val();
		var Organizerm = $("#txtOrganizerm").val();
		var Count = 0;
		$(".refOrganizerm3").each(function(){
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
				url: 'setup/referentialFiles/events_organizerm/class.php',
				data: 'Code=' + Code + '&Organizerm=' + Organizerm +  '&form=fncSaveOrganizerm',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Organizer Materials successfully saved.", "fncCancelBtnOrganizerm", null, "", null, "0");
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

	function fncClickUpdateOrganizerm(){
		var Code = $("#txtOrganizermCode").val();
		if(Code == ""){
			setTimeout(function(){
				showmodal("alert", "Select Organizer Materials first.", "", null, "", null, "1");
			}, 500)
		}else{
			$("#tblref_Organizerm tr").unbind("click");
			$("#btnMainOrganizerm").css("display", "none");
			$("#btnUpdateOrganizerm").css("display", "block");
			$(".refOrganizerm3").removeAttr("readonly");
			$("#txtOrganizermCode").removeAttr("readonly");
		}
	}

	function fncUpdateOrganizerm(){
		var OrganizermID = $("#HiddenOrganizermID").val();
	    var Code = $("#txtOrganizermCode").val();
		var Organizerm = $("#txtOrganizerm").val();
		var Count = 0;
		$(".refOrganizerm3").each(function(){
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
				url: 'setup/referentialFiles/events_organizerm/class.php',
				data: 'Code=' + Code + '&Organizerm=' + Organizerm + '&OrganizermID=' + OrganizermID + '&form=fncUpdateOrganizerm',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Organizer Materials successfully updated.", "fncCancelBtnOrganizerm", null, "", null, "0");
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

	function fncClickDeleteOrganizerm(){
	    var Code = $("#txtOrganizermCode").val();
		var Organizerm = $("#txtOrganizerm").val();
		if(Organizerm == ""){
			setTimeout(function(){
				showmodal("alert", "Select Organizer Materials first.", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to delete " + Organizerm + "?", "fncClickDeleteOrganizerm2", null, "", null, "0");
			}, 500)
		}
	}

	function fncClickDeleteOrganizerm2(){
		var Code = $("#HiddenOrganizermID").val();
		var Organizerm = $("#txtOrganizerm").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_organizerm/class.php',
			data: 'Code=' + Code + '&form=fncClickDeleteOrganizerm',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", Organizerm + " has been deleted.", "fncCancelBtnOrganizerm", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidateOrganizerm(){
		var key = $('#txtSearchOrganizerm').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_organizerm/class.php',
			data: 'key=' + key + '&form=AutoConsolidateOrganizerm',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of Organizer Materials successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of Organizer Materials.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>