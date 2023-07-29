<script type="text/javascript">
	$(function(){
		$("#txtManpowerAmount").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });
		$("#txtManpowerAmount").keydown(function(event) {
            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188) {
            }else{
                if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
                   event.preventDefault(); 
                }   
            }
        });
        $("#txtSearchManpower").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtEntriesManpower").val("1");
				fncManpowerList(); 
			}else if ( x == '8' ){
				if($('#txtSearchManpower').val() == ""){
					$("#txtEntriesManpower").val("1");
					fncManpowerList();
				}
			}
		});

		$(function(){
			$('.btnsortdash-eventsmanpower').click(function(){
				if($(this).hasClass("fa-sort-up")){
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#ManpowerSortType").val("ASC");
					$("#ManpowerSortBy").val(this.id);
					fncManpowerList();
				}
				else if($(this).hasClass("fa-sort-down")){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#ManpowerSortType").val("DESC");
					$("#ManpowerSortBy").val(this.id);
					fncManpowerList();
				}else if($(this).hasClass("fa-sort")){
					if($("#ManpowerSortType").val() == "ASC"){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#ManpowerSortType").val("DESC");
						$("#ManpowerSortBy").val(this.id);
						fncManpowerList();
					}else{
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#ManpowerSortType").val("ASC");
						$("#ManpowerSortBy").val(this.id);
						fncManpowerList();
					}
				}
			});
		});
	})

	function fncManpowerList() {
		var ManpowerSortBy = $('#ManpowerSortBy').val();
		var ManpowerSortType = $('#ManpowerSortType').val();
	    var page = $("#txtPageManpower").val();
		var key = $("#txtSearchManpower").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_manpower/class.php',
			data: 'page=' + page + '&key=' + key + '&ManpowerSortBy=' + ManpowerSortBy + '&ManpowerSortType=' + ManpowerSortType + '&form=fncManpowerList',
			success: function(data){
				if(data == ''){
					$("#tblref_Manpower").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_Manpower").html(data);
				}
			}, complete: function(){
				fncManpowerSelect();
				loadEntriesManpower();
				loadPageManpower();
			}
		})
	}

	function loadEntriesManpower(){
	    var page = $("#txtPageManpower").val();
	    var key = $("#txtSearchManpower").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/events_manpower/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesManpower',
	        success: function(data){
	            $("#txtEntriesManpower").text(data);
	        }
	    });
	}

	function loadPageManpower(){
	    var page = $("#txtPageManpower").val();
	    var key = $("#txtSearchManpower").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/events_manpower/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageManpower',
	        success: function(data){
	            $("#ulPageManpower").html(data);
	        }
	    });
	}

    function fncPageManpower(page, pagenums){
        $(".pgnumManpower").removeClass("active");
        $("#pgManpower" + pagenums).addClass("active");
        $("#txtPageManpower").val(page);
        fncManpowerList();
    }

	function fncManpowerSelect(){
		$("#tblref_Manpower tr").each(function(){
			$(this).click(function(){
				$("#tblref_Manpower tr").removeClass("selected");
				$(this).addClass("selected");
				fncManpowerSelected(this.id);
			})
		})
	}

	function fncManpowerSelected(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_manpower/class.php',
			data: 'id=' + id + '&form=fncManpowerSelected',
			success: function(data) {
				var arr = data.split("|");
				$("#txtManpowerCode").val(id);
				$("#txtManpower").val(arr[0]);
				$("#txtManpowerAmount").val(arr[1]);
				$("#HiddenManpowerID").val(arr[2]);
			}
		})
	}

	function fncClickAddManpower(){
		$("#tblref_Manpower tr").unbind("click");
		$("#tblref_Manpower tr").removeClass("selected");
		$("#btnMainManpower").css("display", "none");
		$("#btnSaveManpower").css("display", "block");
		$(".refManpower3").removeAttr("readonly");
		$(".refManpower3").val("");
	}

	function fncCancelBtnManpower(){
		fncManpowerList();
		$("#btnMainManpower").css("display", "block");
		$("#btnSaveManpower").css("display", "none");
		$("#btnUpdateManpower").css("display", "none");
		$(".refManpower3").attr("readonly", "readonly");
		$(".refManpower3").val("");
        $(".refManpower3").css("border-color","#D5D5D5");
	}

	function fncSaveManpower(){
		var Code = $("#txtManpowerCode").val();
		var Manpower = $("#txtManpower").val();
		var Amount = $("#txtManpowerAmount").val().replace(/,/g,"");
		var count = 0;
		$(".refManpower3").each(function(){
			if($(this).val() == ""){
                $(this).css("border-color","#f2a696");
                Count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
		})
		if(count == 0){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/events_manpower/class.php',
				data: 'Code=' + Code + '&Manpower=' + Manpower + '&Amount=' + Amount + '&form=fncSaveManpower',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Manpower successfully saved.", "fncCancelBtnManpower", null, "", null, "0");
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

	function fncClickUpdateManpower(){
		var Code = $("#txtManpowerCode").val();
		if(Code == ""){
			setTimeout(function(){
				showmodal("alert", "Select Manpower first.", "", null, "", null, "1");
			}, 500)
		}else{
			$("#tblref_Manpower tr").unbind("click");
			$("#btnMainManpower").css("display", "none");
			$("#btnUpdateManpower").css("display", "block");
			$(".refManpower3").removeAttr("readonly");
			$("#txtManpowerCode").removeAttr("readonly");
		}
	}

	function fncUpdateManpower(){
		var ManpowerID = $("#HiddenManpowerID").val();
	    var Code = $("#txtManpowerCode").val();
		var Manpower = $("#txtManpower").val();
		var Amount = $("#txtManpowerAmount").val().replace(/,/g,"");
		var count = 0;
		$(".refManpower3").each(function(){
			if($(this).val() == ""){
                $(this).css("border-color","#f2a696");
                Count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
		})
		if(count == 0){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/events_manpower/class.php',
				data: 'Code=' + Code + '&Manpower=' + Manpower + '&Amount=' + Amount + '&ManpowerID=' + ManpowerID + '&form=fncUpdateManpower',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Manpower successfully updated.", "fncCancelBtnManpower", null, "", null, "0");
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

	function fncClickDeleteManpower(){
	    var Code = $("#txtManpowerCode").val();
		var Manpower = $("#txtManpower").val();
		if(Manpower == ""){
			setTimeout(function(){
				showmodal("alert", "Select Manpower first.", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to delete " + Manpower + "?", "fncClickDeleteManpower2", null, "", null, "0");
			}, 500)
		}
	}

	function fncClickDeleteManpower2(){
		var Code = $("#HiddenManpowerID").val();
		var Manpower = $("#txtManpower").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_manpower/class.php',
			data: 'Code=' + Code + '&form=fncClickDeleteManpower',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", Manpower + " has been deleted.", "fncCancelBtnManpower", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidateManpower(){
		var key = $('#txtSearchManpower').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_manpower/class.php',
			data: 'key=' + key + '&form=AutoConsolidateManpower',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of Manpower successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of manpower.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>