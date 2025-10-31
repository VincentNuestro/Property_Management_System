<script type="text/javascript">
	$(function(){
		$("#txtPageClassification").val("1");
		displayUnitClass();
		$("#txtsearchunitclass").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageClassification").val("1");
				displayUnitClass(); 
			}else if ( x == '8' ){
				if($('#txtsearchunitclass').val() == ""){
					$("#txtPageClassification").val("1");
					displayUnitClass();
				}
			}
		});
		
			$(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash-unitClass').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#ClassificationSortType").val("ASC");
						$("#ClassificationSortBy").val(this.id);
						displayUnitClass();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#ClassificationSortType").val("DESC");
						$("#ClassificationSortBy").val(this.id);
						displayUnitClass();
					}else if($(this).hasClass("fa-sort")){
						// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#ClassificationSortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#ClassificationSortType").val("DESC");
							$("#ClassificationSortBy").val(this.id);
							displayUnitClass();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#ClassificationSortType").val("ASC");
							$("#ClassificationSortBy").val(this.id);
							displayUnitClass();
						}
					}
				});
			// });
		});
	});

	function displayUnitClass(){
		var ClassificationSortBy = $('#ClassificationSortBy').val();
		var ClassificationSortType = $('#ClassificationSortType').val();
	    var page = $("#txtPageClassification").val();
		var key = $("#txtsearchunitclass").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_classification/class.php',
			data: 'page=' + page + '&key=' + key + '&ClassificationSortBy=' + ClassificationSortBy + '&ClassificationSortType=' + ClassificationSortType +'&form=displayUnitClass',
			success: function(data) {
				// alert(data);
				if(data == ''){
					$("#tblref_merchandise_class").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_merchandise_class").html(data);
				}
			}, complete: function(){
				classselected();
				loadEntriesClassification();
				loadPageClassification();
			}
		})
	}

	function loadEntriesClassification(){
	    var page = $("#txtPageClassification").val();
	    var key = $("#txtsearchunitclass").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_classification/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesClassification',
	        success: function(data){
	            $("#txtEntriesClassification").text(data);
	        }
	    });
	}

	function loadPageClassification(){
	    var page = $("#txtPageClassification").val();
	    var key = $("#txtsearchunitclass").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_classification/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageClassification',
	        success: function(data){
	            $("#ulPageClassification").html(data);
	        }
	    });
	}

    function fncPageClassification(page, pagenums){
        $(".pgnumClassification").removeClass("active");
        $("#pgClassification" + pagenums).addClass("active");
        $("#txtPageClassification").val(page);
        displayUnitClass();
    }

	function classselected(){
		$("#tblref_merchandise_class tr").each(function(){
			$(this).click(function(){
				$("#tblref_merchandise_class tr").removeClass("selected");
				$(this).addClass("selected");
				selectedClass(this.id);
			})
		})
	}

	function selectedClass(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_classification/class.php',
			data: 'id=' + id + '&form=selectedClass',
			success: function(data) {
				var arr = data.split("|");
				$("#hiddenclassid").val(arr[0]);
				$("#classCode").val(arr[1]);
				$("#classDesc").val(arr[2]);
			}
		})
	}

	function clickAddClass(){
		$("#tblref_merchandise_class tr").unbind("click");
		$("#tblref_merchandise_class tr").removeClass("selected");
		$("#buttonsClass").css("display", "none");
		$("#savingbuttonsClass").css("display", "block");
		$(".txtUnitClass").removeAttr("readonly");
		$(".txtUnitClass").val("");
	}

	function cancelbuttonClass(){
		displayUnitClass();
		$("#buttonsClass").css("display", "block");
		$("#savingbuttonsClass").css("display", "none");
		$("#updatebuttonsClass").css("display", "none");
		$(".txtUnitClass").attr("readonly", "readonly");
		$(".txtUnitClass").val("");
        $(".txtUnitClass").css("border-color","#D5D5D5");
	}

	function saveClass(){
		var classCode = $("#classCode").val();
		var classDesc = $("#classDesc").val();
		var Count = 0;
		$(".txtUnitClass").each(function(){
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
				url: 'setup/referentialFiles/unit_classification/class.php',
				data: 'classCode=' + classCode + '&classDesc=' + classDesc + '&form=saveClass',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Classification successfully saved.", "cancelbuttonClass", null, "", null, "0");
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

	function clickUpdateClass(){
		var classCode = $("#classCode").val();
		if(classCode == ""){
			setTimeout(function(){
				showmodal("alert", "Select classification first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/unit_classification/class.php',
				data: 'classCode=' + classCode + '&form=chkRecord',
				success:function(data){
					if(data == 0){
						$("#tblref_merchandise_class tr").unbind("click");
						$("#buttonsClass").css("display", "none");
						$("#updatebuttonsClass").css("display", "block");
						$(".txtUnitClass").removeAttr("readonly");
					}else{
						$("#tblref_merchandise_class tr").unbind("click");
						$("#buttonsClass").css("display", "none");
						$("#updatebuttonsClass").css("display", "block");
						$("#classDesc").removeAttr("readonly");
					}
				}
			})
		}
	}

	function updateClass(){
		var hiddenclassid = $("#hiddenclassid").val();
		var classCode = $("#classCode").val();
		var classDesc = $("#classDesc").val();
		var Count = 0;
		$(".txtUnitClass").each(function(){
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
				url: 'setup/referentialFiles/unit_classification/class.php',
				data: 'hiddenclassid=' + hiddenclassid + '&classCode=' + classCode + '&classDesc=' + classDesc + '&form=updateClass',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Classification successfully updated.", "cancelbuttonClass", null, "", null, "0");
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

	function clickDeleteClass(){
		var classCode = $("#classCode").val();
		var classDesc = $("#classDesc").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/unit_classification/class.php',
			data: 'classCode=' + classCode + '&form=chkRecord',
			success: function(data){
				if(data == 0){
					if(classCode == ""){
						setTimeout(function(){
							showmodal("alert", "Select classification first", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("confirm", "Are you sure you want to delete " + classDesc, "clickDeleteClass2", null, "", null, "0");
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

	function clickDeleteClass2(){
		var classCode = $("#classCode").val();
		var classDesc = $("#classDesc").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_classification/class.php',
			data: 'classCode=' + classCode + '&classDesc=' + classDesc + '&form=deleteClass',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", classDesc + " has been deleted.", "cancelbuttonClass", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidateClassification(){
		var key = $('#txtsearchunitclass').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_classification/class.php',
			data: 'key=' + key + '&form=AutoConsolidateClassification',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of classification successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of classification.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>