<script type="text/javascript">
	$(function(){
		$("#txtsearchRequestCategory").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageRequestCategory").val("1");
				displayRequestCategory(); 
			}else if ( x == '8' ){
				if($('#txtsearchRequestCategory').val() == ""){
					$("#txtPageRequestCategory").val("1");
					displayRequestCategory();
				}
			}
		});

		$(function(){
		// $(".btnsortdash").each(function(){
			$('.btnsortdash-requestcat').click(function(){
				if($(this).hasClass("fa-sort-up")){
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#requestcatSortType").val("ASC");
					$("#requestcatSortBy").val(this.id);
					displayRequestCategory();
				}
				else if($(this).hasClass("fa-sort-down")){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#requestcatSortType").val("DESC");
					$("#requestcatSortBy").val(this.id);
					displayRequestCategory();
				}else if($(this).hasClass("fa-sort")){
					// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
					if($("#requestcatSortType").val() == "ASC"){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#requestcatSortType").val("DESC");
						$("#requestcatSortBy").val(this.id);
						displayRequestCategory();
					}else{
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#requestcatSortType").val("ASC");
						$("#requestcatSortBy").val(this.id);
						displayRequestCategory();
					}
				}
			});
		// });
		});
	});

	function displayRequestCategory(){
		var requestcatSortBy = $('#requestcatSortBy').val();
		var requestcatSortType = $('#requestcatSortType').val();
	    var page = $("#txtPageRequestCategory").val();
		var key = $("#txtsearchRequestCategory").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/request_category/class.php',
			data: 'page=' + page + '&key=' + key + '&requestcatSortBy=' + requestcatSortBy + '&requestcatSortType=' + requestcatSortType + '&form=displayRequestCategory',
			success: function(data) {
				if(data == ''){
					$("#tblref_RequestCategory").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_RequestCategory").html(data);
				}
			}, complete: function(){
				RequestCategorySelected();
				loadEntriesRequestCategory();
				loadPageRequestCategory();
			}
		})
	}


	function loadEntriesRequestCategory(){
	    var page = $("#txtPageRequestCategory").val();
	    var key = $("#txtsearchRequestCategory").val();
	    $.ajax({
        type: 'POST',
		url: 'setup/referentialFiles/request_category/class.php',
        data: 'key=' + key + '&page=' + page + '&form=loadEntriesRequestCategory',
        success: function(data){
            $("#txtEntriesRequestCategory").text(data);
	        }
	    });
	}

	function loadPageRequestCategory(){
	    var page = $("#txtPageRequestCategory").val();
	    var key = $("#txtsearchRequestCategory").val();
    $.ajax({
        type: 'POST',
		url: 'setup/referentialFiles/request_category/class.php',
        data: 'key=' + key + '&page=' + page + '&form=loadPageRequestCategory',
        success: function(data){
            $("#ulPageRequestCategory").html(data);
	        }
	    });
	}

    function fncPageRequestCategory(page, pagenums){
    $(".pgnumRequestCategory").removeClass("active");
    $("#pgRequestCategory" + pagenums).addClass("active");
    $("#txtPageRequestCategory").val(page);
    displayRequestCategory();
    }

	function RequestCategorySelected(){
		$("#tblref_RequestCategory tr").each(function(){
			$(this).click(function(){
				$("#tblref_RequestCategory tr").removeClass("selected");
				$(this).addClass("selected");
				selectedRequestCategory(this.id);
			})
		})
	}

	function selectedRequestCategory(id) {
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/request_category/class.php',
			data: 'id=' + id + '&form=selectedRequestCategory',
			success: function(data) {
				var arr = data.split("|");
				$("#hiddenRequestCategoryid").val(arr[2]);
				$("#RequestCategoryCode").val(arr[0]);
				$("#RequestCategoryDesc").val(arr[1]);
			}
		}) 
	}

	function clickAddRequestCategory(){
		$("#tblref_RequestCategory tr").unbind("click");
		$("#tblref_RequestCategory tr").removeClass("selected");
		$("#buttonsRequestCategory").css("display", "none");
		$("#savingbuttonsRequestCategory").css("display", "block");
		$(".txtRequestCategory").removeAttr("readonly");
		$(".txtRequestCategory").val("");
	}

	function cancelbuttonRequestCategory(){
		displayRequestCategory();
		$("#buttonsRequestCategory").css("display", "block");
		$("#savingbuttonsRequestCategory").css("display", "none");
		$(".txtRequestCategory").attr("readonly", "readonly");
		$(".txtRequestCategory").val(""); 
	}

	function cancelbuttonRequestCategory2(){
		displayRequestCategory();
		$("#buttonsRequestCategory").css("display", "block");
		$("#updatebuttonsRequestCategory").css("display", "none");
		$(".txtRequestCategory").attr("readonly", "readonly");
	}				    

	function saveRequestCategory(){
		var RequestCategoryCode = $("#RequestCategoryCode").val();
		var RequestCategoryDesc = $("#RequestCategoryDesc").val();
		if($("#RequestCategoryCode").val() != "" && $("#RequestCategoryDesc").val() != ""){			
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/request_category/class.php',
				data: 'RequestCategoryCode=' + RequestCategoryCode + '&RequestCategoryDesc=' + RequestCategoryDesc + '&form=saveRequestCategory',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Request category successfully saved.", "cancelbuttonRequestCategory", null, "", null, "0");
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

	function clickUpdateRequestCategory(){
		var RequestCategoryCode = $("#RequestCategoryCode").val();
		var RequestCategoryDesc = $("#RequestCategoryDesc").val();
		if(RequestCategoryDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select Request first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/request_category/class.php',
				data: 'RequestCategoryCode=' + RequestCategoryCode + '&form=clickUpdateRequestCategory',
				success:function(data){
					if(data == 0){
						$("#tblref_RequestCategory tr").unbind("click");
						$("#buttonsRequestCategory").css("display", "none");
						$("#updatebuttonsRequestCategory").css("display", "block");
						$(".txtRequestCategory").removeAttr("readonly");
					}else{
						$("#tblref_RequestCategory tr").unbind("click");
						$("#buttonsRequestCategory").css("display", "none");
						$("#updatebuttonsRequestCategory").css("display", "block");
						$("#RequestCategoryDesc").removeAttr("readonly");
					}
				}
			})
		}
	}


	function updateRequestCategory(){
		var hiddenRequestCategoryid = $("#hiddenRequestCategoryid").val();
		var RequestCategoryCode = $("#RequestCategoryCode").val();
		var RequestCategoryDesc = $("#RequestCategoryDesc").val();
		if($("#RequestCategoryCode").val() != "" && $("#RequestCategoryDesc").val() != ""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/request_category/class.php',
				data: 'hiddenRequestCategoryid=' + hiddenRequestCategoryid + '&RequestCategoryCode=' + RequestCategoryCode + '&RequestCategoryDesc=' + RequestCategoryDesc + '&form=updateRequestCategory',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Request category successfully updated.", "cancelbuttonRequestCategory2", null, "", null, "0");
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


	function clickDeleteRequestCategory(){
		var RequestCategoryCode = $("#hiddenRequestCategoryid").val();
		var RequestCategoryDesc = $("#RequestCategoryDesc").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/request_category/class.php',
			data: 'RequestCategoryCode=' + RequestCategoryCode + '&form=clickUpdateRequestCategory',
			success:function(data){
				if(data == 0){
					if(RequestCategoryCode == ""){
						setTimeout(function(){
							showmodal("alert", "Select Request first", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("confirm", "Are you sure you want to delete " + RequestCategoryDesc, "clickDeleteRequestCategory2", null, "", null, "0");
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

	function clickDeleteRequestCategory2(){
		var RequestCategoryCode = $("#hiddenRequestCategoryid").val();  
		var RequestCategoryDesc = $("#RequestCategoryDesc").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/request_category/class.php',
			data: 'RequestCategoryCode=' + RequestCategoryCode + '&RequestCategoryDesc=' + RequestCategoryDesc + '&form=deleteRequestCategory',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", RequestCategoryDesc + " has been deleted.", "displayRequestCategory", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}	
</script>	