<script type="text/javascript">
	$(function(){
		$("#txtSearchSource").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageSource").val("1");
				displayListofSource(); 
			}else if ( x == '8' ){
				if($('#txtSearchSource').val() == ""){
					$("#txtPageSource").val("1");
					displayListofSource();
				}
			}
		});
		$(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash-source').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#SourceSortType").val("ASC");
						$("#SourceSortBy").val(this.id);
						displayListofSource();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#SourceSortType").val("DESC");
						$("#SourceSortBy").val(this.id);
						displayListofSource();
					}else if($(this).hasClass("fa-sort")){
						// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#SourceSortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#SourceSortType").val("DESC");
							$("#SourceSortBy").val(this.id);
							displayListofSource();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#SourceSortType").val("ASC");
							$("#SourceSortBy").val(this.id);
							displayListofSource();
						}
					}
				});
			// });
		});
	});

	function displayListofSource() {
		var SourceSortBy = $('#SourceSortBy').val();
		var SourceSortType = $('#SourceSortType').val();
		var key = $("#txtSearchSource").val();
	    var page = $("#txtPageSource").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_source/class.php',
			data: 'page=' + page + '&key=' + key + '&SourceSortBy=' + SourceSortBy + '&SourceSortType=' + SourceSortType + '&form=displayListofSource',
			success: function(data){
				if(data == ''){
					$("#tblrefSource").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblrefSource").html(data);
				}
			}, complete: function(){
				SelectedSource();
				loadEntriesSource();
				loadPageSource();
			}
		})
	}

	function loadEntriesSource(){
	    var page = $("#txtPageSource").val();
	    var key = $("#txtSearchSource").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/oth_source/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesSource',
	        success: function(data){
	            $("#txtEntriesSource").text(data);
	        }
	    });
	}

	function loadPageSource(){
	    var page = $("#txtPageSource").val();
	    var key = $("#txtSearchSource").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/oth_source/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageSource',
	        success: function(data){
	            $("#ulPageSource").html(data);
	        }
	    });
	}

    function fncPageSource(page, pagenums){
        $(".pgnumSource").removeClass("active");
        $("#pgSource" + pagenums).addClass("active");
        $("#txtPageSource").val(page);
        displayListofSource();
    }

	function SelectedSource(){
		$("#tblrefSource tr").each(function(){
			$(this).click(function(){
				$("#tblrefSource tr").removeClass("selected");
				$(this).addClass("selected");
				fncloadSelectedSource(this.id);
			})
		})
	}

	function fncloadSelectedSource(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_source/class.php',
			data: 'id=' + id + '&form=fncloadSelectedSource',
			success: function(data) {
				var arr = data.split("|");
				$("#hiddenSourceID").val(id);
				$("#txtSourceCode").val(arr[0]);
		        $("#txtSourceDesc").val(arr[1]);
			}
		})
	}

	function clickAddSource(){
		$("#tblrefSource tr").unbind("click");
		$("#tblrefSource tr").removeClass("selected");
		$("#buttonsSource").css("display", "none");
		$("#savingbuttonsSource").css("display", "block");
		$(".txtSource").removeAttr("readonly");
		$(".txtSource").val("");
		$(".overridepermit").prop("disabled", false);
	}

	function cancelbuttonSource(){
		displayListofSource();
		$("#buttonsSource").css("display", "block");
		$("#savingbuttonsSource").css("display", "none");
		$("#updatebuttonsSource").css("display", "none");
		$(".txtSource").attr("readonly", "readonly");
		$(".txtSource").val("");
		$(".overridepermit").prop("disabled", true);
        $(".txtSource").css("border-color","#D5D5D5");
	}

	function saveSource(){
		var SourceCode = $("#txtSourceCode").val();
		var SourceDesc = $("#txtSourceDesc").val();
		var Count = 0;
		$(".txtSource").each(function(){
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
				url: 'setup/referentialFiles/oth_source/class.php',
				data: 'SourceCode=' + SourceCode + '&SourceDesc=' + SourceDesc + '&form=saveSource',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Source successfully saved.", "cancelbuttonSource", null, "", null, "0");
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

	function clickUpdateSource() {
		var SourceCode = $("#txtSourceCode").val();
		if(SourceCode == ""){
			setTimeout(function(){
				showmodal("alert", "Select Source first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/oth_source/class.php',
				data: 'SourceCode=' + SourceCode + '&form=clickUpdateSource',
				success: function(data){
					if(data == "1"){
						$("#tblrefSource tr").unbind("click");
						$("#buttonsSource").css("display", "none");
						$("#updatebuttonsSource").css("display", "block");
						$("#txtSourceCode").attr("readonly", "readonly");
					}else{
						$("#tblrefSource tr").unbind("click");
						$("#buttonsSource").css("display", "none");
						$("#updatebuttonsSource").css("display", "block");
						$(".txtSource").removeAttr("readonly");
					}
				}
			})
		}
	}

	function updateSource() {
		var hiddenSourceID = $("#hiddenSourceID").val();
		var SourceCode = $("#txtSourceCode").val();
		var SourceDesc = $("#txtSourceDesc").val();
		var Count = 0;
		$(".txtSource").each(function(){
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
				url: 'setup/referentialFiles/oth_source/class.php',
				data: 'hiddenSourceID=' + hiddenSourceID + '&SourceCode=' + SourceCode + '&SourceDesc=' + SourceDesc + '&form=updateSource',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Source successfully updated.", "cancelbuttonSource", null, "", null, "0");
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

	function clickDeleteSource() {
		var SourceDesc = $("#txtSourceDesc").val();
		var hiddenSourceID = $("#hiddenSourceID").val();
		if(SourceDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select source first", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to delete " + SourceDesc, "clickDeleteSource2", null, "", null, "0");
			}, 500)
		}
	}

	function clickDeleteSource2(){
		var SourceDesc = $("#txtSourceDesc").val();
		var hiddenSourceID = $("#hiddenSourceID").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_source/class.php',
			data: 'hiddenSourceID=' + hiddenSourceID + '&form=deleteSource',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", SourceDesc + " has been deleted.", "cancelbuttonSource", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidateSource(){
		var key = $('#txtsearchunitclass').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/oth_source/class.php',
			data: 'key=' + key + '&form=AutoConsolidateSource',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of source successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of source.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>