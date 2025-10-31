<script type="text/javascript">
	$(function(){
		$("#txtsearchindustry").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageIndustry").val("1");
				displayIndustry(); 
			}else if ( x == '8' ){
				if($('#txtsearchindustry').val() == ""){
					$("#txtPageIndustry").val("1");
					displayIndustry();
				}
			}
		});

		$(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash-unitindustry').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#IndustrySortType").val("ASC");
						$("#IndustrySortBy").val(this.id);
						displayIndustry();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#IndustrySortType").val("DESC");
						$("#IndustrySortBy").val(this.id);
						displayIndustry();
					}else if($(this).hasClass("fa-sort")){
						// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#IndustrySortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#IndustrySortType").val("DESC");
							$("#IndustrySortBy").val(this.id);
							displayIndustry();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#IndustrySortType").val("ASC");
							$("#IndustrySortBy").val(this.id);
							displayIndustry();
						}
					}
				});
			// });
		});
	});
	
	function displayIndustry(){
		var IndustrySortBy = $('#IndustrySortBy').val();
		var IndustrySortType = $('#IndustrySortType').val();
	    var page = $("#txtPageIndustry").val();
		var key = $("#txtsearchindustry").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_industry/class.php',
			data: 'page=' + page + '&key=' + key + '&IndustrySortBy=' + IndustrySortBy + '&IndustrySortType=' + IndustrySortType + '&form=displayIndustry',
			success: function(data) {
				// alert(data);
				if(data == ''){
					$("#tblref_industry").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_industry").html(data);
				}
			}, complete: function(){
				industrySelected();
				loadEntriesIndustry();
				loadPageIndustry();
			}
		})
	}

	function loadEntriesIndustry(){
	    var page = $("#txtPageIndustry").val();
	    var key = $("#txtsearchindustry").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_industry/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesIndustry',
	        success: function(data){
	            $("#txtEntriesIndustry").text(data);
	        }
	    });
	}

	function loadPageIndustry(){
	    var page = $("#txtPageIndustry").val();
	    var key = $("#txtsearchindustry").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_industry/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageIndustry',
	        success: function(data){
	            $("#ulPageIndustry").html(data);
	        }
	    });
	}

    function fncPageIndustry(page, pagenums){
        $(".pgnumIndustry").removeClass("active");
        $("#pgIndustry" + pagenums).addClass("active");
        $("#txtPageIndustry").val(page);
        displayIndustry();
    }

	function industrySelected(){
		$("#tblref_industry tr").each(function(){
			$(this).click(function(){
				$("#tblref_industry tr").removeClass("selected");
				$(this).addClass("selected");
				selectedIndustry(this.id);
			})
		})
	}

	function selectedIndustry(id) {
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_industry/class.php',
			data: 'id=' + id + '&form=selectedIndustry',
			success: function(data) {
				var arr = data.split("|");
				$("#hiddenindustryid").val(arr[2]);
				$("#industryCode").val(arr[0]);
				$("#industryDesc").val(arr[1]);
			}
		})
	}

	function clickAddIndustry(){
		$("#tblref_industry tr").unbind("click");
		$("#tblref_industry tr").removeClass("selected");
		$("#buttonsIndustry").css("display", "none");
		$("#savingbuttonsIndustry").css("display", "block");
		$(".txtIndustry").removeAttr("readonly");
		$(".txtIndustry").val("");
	}

	function cancelbuttonIndustry(){
		displayIndustry();
		$("#buttonsIndustry").css("display", "block");
		$("#savingbuttonsIndustry").css("display", "none");
		$("#updatebuttonsIndustry").css("display", "none");
		$(".txtIndustry").attr("readonly", "readonly");
		$(".txtIndustry").val("");
        $(".txtIndustry").css("border-color","#D5D5D5");
	}

	function saveIndustry(){
		var industryCode = $("#industryCode").val();
		var industryDesc = $("#industryDesc").val();
		var Count = 0;
		$(".txtIndustry").each(function(){
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
				url: 'setup/referentialFiles/unit_industry/class.php',
				data: 'industryCode=' + industryCode + '&industryDesc=' + industryDesc + '&form=saveIndustry',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Industry successfully saved.", "cancelbuttonIndustry", null, "", null, "0");
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

	function clickUpdateIndustry(){
		var industryCode = $("#industryCode").val();
		var industryDesc = $("#industryDesc").val();
		if(industryDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select industry first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/unit_industry/class.php',
				data: 'industryCode=' + industryCode + '&form=clickUpdateIndustry',
				success:function(data){
					if(data == 0){
						$("#tblref_industry tr").unbind("click");
						$("#buttonsIndustry").css("display", "none");
						$("#updatebuttonsIndustry").css("display", "block");
						$(".txtIndustry").removeAttr("readonly");
					}else{
						$("#tblref_industry tr").unbind("click");
						$("#buttonsIndustry").css("display", "none");
						$("#updatebuttonsIndustry").css("display", "block");
						$("#industryDesc").removeAttr("readonly");
					}
				}
			})
		}
	}

	function updateIndustry(){
		var hiddenindustryid = $("#hiddenindustryid").val();
		var industryCode = $("#industryCode").val();
		var industryDesc = $("#industryDesc").val();
		var Count = 0;
		$(".txtIndustry").each(function(){
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
				url: 'setup/referentialFiles/unit_industry/class.php',
				data: 'hiddenindustryid=' + hiddenindustryid + '&industryCode=' + industryCode + '&industryDesc=' + industryDesc + '&form=updateIndustry',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Industry successfully updated.", "cancelbuttonIndustry", null, "", null, "0");
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

	function clickDeleteIndustry(){
		var industryCode = $("#industryCode").val();
		var industryDesc = $("#industryDesc").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/unit_industry/class.php',
			data: 'industryCode=' + industryCode + '&form=clickUpdateIndustry',
			success:function(data){
				if(data == 0){
					if(industryCode == ""){
						setTimeout(function(){
							showmodal("alert", "Select industry first", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("confirm", "Are you sure you want to delete " + industryDesc, "clickDeleteIndustry2", null, "", null, "0");
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

	function clickDeleteIndustry2(){
		var industryCode = $("#hiddenindustryid").val();
		var industryDesc = $("#industryDesc").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_industry/class.php',
			data: 'industryCode=' + industryCode + '&industryDesc=' + industryDesc + '&form=deleteIndustry',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", industryDesc + " has been deleted.", "cancelbuttonIndustry", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidateIndustry(){
		var key = $('#txtsearchindustry').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_industry/class.php',
			data: 'key=' + key + '&form=AutoConsolidateIndustry',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of industry successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of industry.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>