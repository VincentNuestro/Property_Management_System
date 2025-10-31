<!--START  Michael Capistrano 09-05-2019-->
<script type="text/javascript">
	$(function(){
		showRequestCategory();
		$("#txtsearchRequestTags").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageRequestTags").val("1");
				displayRequestTags(); 
				showRequestCategory();
			}else if ( x == '8' ){
				if($('#txtsearchRequestTags').val() == ""){
					$("#txtPageRequestTags").val("1");
					displayRequestTags();
					showRequestCategory();
				}
			}
		});

		$(function(){
		// $(".btnsortdash").each(function(){
			$('.btnsortdash-requesttag').click(function(){
				if($(this).hasClass("fa-sort-up")){
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#RequesttagSortType").val("ASC");
					$("#RequesttagSortBy").val(this.id);
					displayRequestTags();
					showRequestCategory();
				}
				else if($(this).hasClass("fa-sort-down")){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#RequesttagSortType").val("DESC");
					$("#RequesttagSortBy").val(this.id);
					displayRequestTags();
					showRequestCategory();
				}else if($(this).hasClass("fa-sort")){
					// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
					if($("#RequesttagSortType").val() == "ASC"){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#RequesttagSortType").val("DESC");
						$("#RequesttagSortBy").val(this.id);
						displayRequestTags();
						showRequestCategory();
					}else{
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#RequesttagSortType").val("ASC");
						$("#RequesttagSortBy").val(this.id);
						displayRequestTags();
						showRequestCategory();
					}
				}
			});
		// });
		});
	});

	function showRequestCategory(){
		$.ajax({
			type: 'POST',
			url:  'setup/referentialFiles/request_tags/class.php',
			data: 'form=showRequestCategory',
			success: function(data) {
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
				$("#RequestTagsCat").html(data);
			}
		});
	}

	function displayRequestTags(){
		var RequesttagSortBy = $('#RequesttagSortBy').val();
		var RequesttagSortType = $('#RequesttagSortType').val();
	    var page = $("#txtPageRequestTags").val();
		var key = $("#txtsearchRequestTags").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/request_tags/class.php',
			data: 'page=' + page + '&key=' + key + '&RequesttagSortBy=' + RequesttagSortBy + '&RequesttagSortType=' + RequesttagSortType + '&form=displayRequestTags',
			success: function(data) {
				if(data == ''){
					$("#tblref_RequestTags").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_RequestTags").html(data); 
				}
			}, complete: function(){
				RequestTagsSelected();
				loadEntriesRequestTags();
				loadPageRequestTags();
			}
		})
	}

	function loadEntriesRequestTags(){
	    var page = $("#txtPageRequestTags").val();
	    var key = $("#txtsearchRequestTags").val();
	    $.ajax({
        type: 'POST',
		url: 'setup/referentialFiles/request_tags/class.php',
        data: 'key=' + key + '&page=' + page + '&form=loadEntriesRequestTags',
        success: function(data){
            $("#txtEntriesRequestTags").text(data);
	        }
	    });
	}

	function loadPageRequestTags(){
	    var page = $("#txtPageRequestTags").val();
	    var key = $("#txtsearchRequestTags").val();
    $.ajax({
        type: 'POST',
		url: 'setup/referentialFiles/request_tags/class.php',
        data: 'key=' + key + '&page=' + page + '&form=loadPageRequestTags',
        success: function(data){
            $("#ulPageRequestTags").html(data);
	        }
	    });
	}

    function fncPageRequestTags(page, pagenums){
    $(".pgnumRequestTags").removeClass("active");
    $("#pgRequestTags" + pagenums).addClass("active");
    $("#txtPageRequestTags").val(page);
    displayRequestTags();
    }

	function RequestTagsSelected(){
		$("#tblref_RequestTags tr").each(function(){
			$(this).click(function(){
				$("#tblref_RequestTags tr").removeClass("selected");
				$(this).addClass("selected");
				selectedRequestTags(this.id);
			})
		})
	}

	function selectedRequestTags(id) {
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/request_tags/class.php',
			data: 'id=' + id + '&form=selectedRequestTags',
			success: function(data) {
				var arr = data.split("|");
				$("#hiddenRequestTagsid").val(arr[4]);
				$("#RequestTagsCode").val(arr[0]);
				$("#RequestTagsDesc").val(arr[2]);
				$("#RequestTagsCat").val(arr[1]).trigger("change");
				$(".RequestTagsAppr").each(function(){
		            if($(this).val() == arr[3]){ 
		            	$(this).prop("checked", true); 
		            }
		        });								
			}
		}) 
	}

	function clickAddRequestTags(){
		$("#tblref_RequestTags tr").unbind("click");
		$("#tblref_RequestTags tr").removeClass("selected");
		$("#buttonsRequestTags").css("display", "none");
		$("#savingbuttonsRequestTags").css("display", "block");
		$(".txtRequestTags").removeAttr("readonly");
		$(".txtRequestTags").val("");
		$(".RequestTagsAppr").prop("disabled", false);
		$(".selectTags").prop("disabled", false);					
	}

	function cancelbuttonRequestTags(){
		displayRequestTags();
		$("#buttonsRequestTags").css("display", "block");
		$("#savingbuttonsRequestTags").css("display", "none");
		$(".txtRequestTags").attr("readonly", "readonly");
		$(".txtRequestTags").val("");
		$(".RequestTagsAppr").prop("disabled", true);
		$(".selectTags").prop("disabled", true);					 
	}

	function cancelbuttonRequestTags2(){
		displayRequestTags();
		$("#buttonsRequestTags").css("display", "block");
		$("#updatebuttonsRequestTags").css("display", "none");
		$(".txtRequestTags").attr("readonly", "readonly");
		$(".RequestTagsAppr").prop("disabled", true);
		$(".selectTags").prop("disabled", true);			
	}				    

	function saveRequestTags(){
		var RequestTagsCat = $("#RequestTagsCat").val();
		var RequestTagsDesc = $("#RequestTagsDesc").val();
		var RequestTagsCode = $("#RequestTagsCode").val();
		var RequestTagsAppr = "";
	    $(".RequestTagsAppr").each(function(){
	        if($(this).is(":checked") == true){
	          	RequestTagsAppr = this.value;
	        }
	    });
		if($("#RequestTagsAppr").val()!=""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/request_Tags/class.php',
				data: 'RequestTagsCat='+ RequestTagsCat +'&RequestTagsAppr=' + RequestTagsAppr + '&RequestTagsDesc=' + RequestTagsDesc + '&RequestTagsCode=' + RequestTagsCode + '&form=saveRequestTags',
					success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Request Tags successfully saved.", "cancelbuttonRequestTags", null, "", null, "0");
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

	function clickUpdateRequestTags(){
		var RequestTagsCode = $("#RequestTagsCode").val();
		var RequestTagsDesc = $("#RequestTagsDesc").val();
		if(RequestTagsDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select Request Tags first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/request_Tags/class.php',
				data: 'RequestTagsCode=' + RequestTagsCode + '&form=clickUpdateRequestTags',
				success:function(data){
					if(data == 0){
						$("#tblref_RequestTags tr").unbind("click");
						$("#buttonsRequestTags").css("display", "none");
						$("#updatebuttonsRequestTags").css("display", "block");
						$(".txtRequestTags").removeAttr("readonly");
						$(".RequestTagsAppr").prop("disabled", false);
						$(".selectTags").prop("disabled", false);
					}else{
						$("#tblref_RequestTags tr").unbind("click");
						$("#buttonsRequestTags").css("display", "none");
						$("#updatebuttonsRequestTags").css("display", "block");
						$("#RequestTagsDesc").removeAttr("readonly");
						$("#RequestTagsCode").removeAttr("readonly");						
						$(".RequestTagsAppr").prop("disabled", false);	
						$(".selectTags").prop("disabled", false);
					}
				}
			})
		}
	}


	function updateRequestTags(){
		var hiddenRequestTagsid = $("#hiddenRequestTagsid").val();
		var RequestTagsCat = $("#RequestTagsCat").val();
		var RequestTagsCode = $("#RequestTagsCode").val();
		var RequestTagsDesc = $("#RequestTagsDesc").val();
		$(".RequestTagsAppr").each(function(){
	        if($(this).is(":checked") == true){
	          	RequestTagsAppr = this.value;
	        }
	    });
		if($("#RequestTagsCode").val() != "" && $("#RequestTagsDesc").val() != "" && $("#RequestTagsCat").val() != ""){ 
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/request_tags/class.php',
				data: 'hiddenRequestTagsid=' + hiddenRequestTagsid + '&RequestTagsAppr=' + RequestTagsAppr + '&RequestTagsCat='+ RequestTagsCat +'&RequestTagsCode=' + RequestTagsCode + '&RequestTagsDesc=' + RequestTagsDesc + '&form=updateRequestTags',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Request Tags successfully updated.", "cancelbuttonRequestTags2", null, "", null, "0");
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


	function clickDeleteRequestTags(){
		var RequestTagsCode = $("#hiddenRequestTagsid").val();
		var RequestTagsDesc = $("#RequestTagsDesc").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/request_tags/class.php',
			data: 'RequestTagsCode=' + RequestTagsCode + '&form=clickUpdateRequestTags',
			success:function(data){
				if(data == 0){
					if(RequestTagsCode == ""){
						setTimeout(function(){ 
							showmodal("alert", "Select Request Tag first", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("confirm", "Are you sure you want to delete " + RequestTagsDesc, "clickDeleteRequestTags2", null, "", null, "0");
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

	function clickDeleteRequestTags2(){m 
		var RequestTagsCode = $("#hiddenRequestTagsid").val();
		var RequestTagsDesc = $("#RequestTagsDesc").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/request_tags/class.php',
			data: 'RequestTagsCode=' + RequestTagsCode + '&RequestTagsDesc=' + RequestTagsDesc + '&form=deleteRequestTags',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", RequestTagsDesc + " has been deleted.", "displayRequestTags", null, "", null, "0"); 
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

<!-- END Michael Capistrano 09-05-2019-->