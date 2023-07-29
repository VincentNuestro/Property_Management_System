<script type="text/javascript">
	$(function(){
		$("#txtSoundnperAmount").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });
		$("#txtSoundnperAmount").keydown(function(event) {
            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188) {
            }else{
                if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
                   event.preventDefault(); 
                }   
            }
        });
        $("#txtSearchSoundnper").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageSoundnper").val("1");
				fncSoundnperList(); 
			}else if ( x == '8' ){
				if($('#txtSearchSoundnper').val() == ""){
					$("#txtPageSoundnper").val("1");
					fncSoundnperList();
				}
			}
		});
		   $(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash-eventssoundnper').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#SoundnperSortType").val("ASC");
						$("#SoundnperSortBy").val(this.id);
						fncSoundnperList();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#SoundnperSortType").val("DESC");
						$("#SoundnperSortBy").val(this.id);
						fncSoundnperList();
					}else if($(this).hasClass("fa-sort")){
						// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#SoundnperSortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#SoundnperSortType").val("DESC");
							$("#SoundnperSortBy").val(this.id);
							fncSoundnperList();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#SoundnperSortType").val("ASC");
							$("#SoundnperSortBy").val(this.id);
							fncSoundnperList();
						}
					}
				});
			// });
			});
	})

	function fncSoundnperList() {
		var SoundnperSortBy = $('#SoundnperSortBy').val();
		var SoundnperSortType = $('#SoundnperSortType').val();
	    var page = $("#txtPageSoundnper").val();
		var key = $("#txtSearchSoundnper").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_soundnper/class.php',
			data: 'page=' + page + '&key=' + key + '&SoundnperSortBy=' + SoundnperSortBy + '&SoundnperSortType=' + SoundnperSortType + '&form=fncSoundnperList',
			success: function(data){
				if(data == ''){
					$("#tblref_Soundnper").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_Soundnper").html(data);
				}
			}, complete: function(){
				fncSoundnperSelect();
				loadEntriesSoundnper();
				loadPageSoundnper();
			}
		})
	}

	function loadEntriesSoundnper(){
	    var page = $("#txtPageSoundnper").val();
	    var key = $("#txtSearchSoundnper").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/events_soundnper/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesSoundnper',
	        success: function(data){
	            $("#txtEntriesSoundnper").text(data);
	        }
	    });
	}

	function loadPageSoundnper(){
	    var page = $("#txtPageSoundnper").val();
	    var key = $("#txtSearchSoundnper").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/events_soundnper/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageSoundnper',
	        success: function(data){
	            $("#ulPageSoundnper").html(data);
	        }
	    });
	}

    function fncPageSoundnper(page, pagenums){
        $(".pgnumSoundnper").removeClass("active");
        $("#pgSoundnper" + pagenums).addClass("active");
        $("#txtPageSoundnper").val(page);
        fncSoundnperList();
    }


	function fncSoundnperSelect(){
		$("#tblref_Soundnper tr").each(function(){
			$(this).click(function(){
				$("#tblref_Soundnper tr").removeClass("selected");
				$(this).addClass("selected");
				fncSoundnperSelected(this.id);
			})
		})
	}

	function fncSoundnperSelected(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_Soundnper/class.php',
			data: 'id=' + id + '&form=fncSoundnperSelected',
			success: function(data) {
				var arr = data.split("|");
				$("#txtSoundnperCode").val(id);
				$("#txtSoundnper").val(arr[0]);
				$("#txtSoundnperAmount").val(arr[1]);
				$("#HiddenSoundnperID").val(arr[2]);
			}
		})
	}

	function fncClickAddSoundnper(){
		$("#tblref_Soundnper tr").unbind("click");
		$("#tblref_Soundnper tr").removeClass("selected");
		$("#btnMainSoundnper").css("display", "none");
		$("#btnSaveSoundnper").css("display", "block");
		$(".refSoundnper3").removeAttr("readonly");
		$(".refSoundnper3").val("");
	}

	function fncCancelBtnSoundnper(){
		fncSoundnperList();
		$("#btnMainSoundnper").css("display", "block");
		$("#btnSaveSoundnper").css("display", "none");
		$("#btnUpdateSoundnper").css("display", "none");
		$(".refSoundnper3").attr("readonly", "readonly");
		$(".refSoundnper3").val("");
        $(".refSoundnper3").css("border-color","#D5D5D5");
	}

	function fncSaveSoundnper(){
		var Code = $("#txtSoundnperCode").val();
		var Soundnper = $("#txtSoundnper").val();
		var Amount = $("#txtSoundnperAmount").val().replace(/,/g,"");
		var Count = 0;
		$(".refSoundnper3").each(function(){
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
				url: 'setup/referentialFiles/events_soundnper/class.php',
				data: 'Code=' + Code + '&Soundnper=' + Soundnper + '&Amount=' + Amount + '&form=fncSaveSoundnper',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Sound System & Personnel successfully saved.", "fncCancelBtnSoundnper", null, "", null, "0");
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

	function fncClickUpdateSoundnper(){
		var Code = $("#txtSoundnperCode").val();
		if(Code == ""){
			setTimeout(function(){
				showmodal("alert", "Select Sound System & personnel first.", "", null, "", null, "1");
			}, 500)
		}else{
			$("#tblref_Soundnper tr").unbind("click");
			$("#btnMainSoundnper").css("display", "none");
			$("#btnUpdateSoundnper").css("display", "block");
			$(".refSoundnper3").removeAttr("readonly");
			$("#txtSoundnperCode").removeAttr("readonly");
		}
	}

	function fncUpdateSoundnper(){
		var SoundnperID = $("#HiddenSoundnperID").val();
	    var Code = $("#txtSoundnperCode").val();
		var Soundnper = $("#txtSoundnper").val();
		var Amount = $("#txtSoundnperAmount").val().replace(/,/g,"");
		var Count = 0;
		$(".refSoundnper3").each(function(){
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
				url: 'setup/referentialFiles/events_soundnper/class.php',
				data: 'Code=' + Code + '&Soundnper=' + Soundnper + '&Amount=' + Amount + '&SoundnperID=' + SoundnperID + '&form=fncUpdateSoundnper',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Sound System & personnel successfully updated.", "fncCancelBtnSoundnper2", null, "", null, "0");
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

	function fncClickDeleteSoundnper(){
	    var Code = $("#txtSoundnperCode").val();
		var Soundnper = $("#txtSoundnper").val();
		if(Soundnper == ""){
			setTimeout(function(){
				showmodal("alert", "Select Sound System & personnel first.", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to delete " + Soundnper + "?", "fncClickDeleteSoundnper2", null, "", null, "0");
			}, 500)
		}
	}

	function fncClickDeleteSoundnper2(){
		var Code = $("#HiddenSoundnperID").val();
		var Soundnper = $("#txtSoundnper").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_soundnper/class.php',
			data: 'Code=' + Code + '&form=fncClickDeleteSoundnper',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", Soundnper + " has been deleted.", "fncCancelBtnSoundnper", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidateSoundnper(){
		var key = $('#txtSearchSoundnper').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/events_soundnper/class.php',
			data: 'key=' + key + '&form=AutoConsolidateSoundnper',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of Sound System & personnel successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of Sound System & personnel.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>