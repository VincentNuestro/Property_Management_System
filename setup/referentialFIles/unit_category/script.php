<script type="text/javascript">
	$(function(){
		$("#txtPageCategory").val("1");
		displayCat();
		$("#txtsearchCat").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageCategory").val("1");
				displayCat(); 
			}else if ( x == '8' ){
				if($('#txtsearchCat').val() == ""){
					$("#txtPageCategory").val("1");
					displayCat();
				}
			}
		});

		$(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash-unitCategory').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#UnitCategorySortType").val("ASC");
						$("#UnitCategorySortBy").val(this.id);
						displayCat();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#UnitCategorySortType").val("DESC");
						$("#UnitCategorySortBy").val(this.id);
						displayCat();
					}else if($(this).hasClass("fa-sort")){
						// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#UnitCategorySortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#UnitCategorySortType").val("DESC");
							$("#UnitCategorySortBy").val(this.id);
							displayCat();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#UnitCategorySortType").val("ASC");
							$("#UnitCategorySortBy").val(this.id);
							displayCat();
						}
					}
				});
			// });
		});
	});

	function displayCat(){
		var UnitCategorySortBy = $('#UnitCategorySortBy').val();
		var UnitCategorySortType = $('#UnitCategorySortType').val();
	    var page = $("#txtPageCategory").val();
		var key = $("#txtsearchCat").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_category/class.php',
			data: 'page=' + page + '&key=' + key + '&UnitCategorySortBy=' + UnitCategorySortBy + '&UnitCategorySortType=' + UnitCategorySortType + '&form=displayCat',
			success:function(data){
				if(data == ''){
					$("#tblref_merchandisedep_cat").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_merchandisedep_cat").html(data);
				}
			}, complete: function(){
				catSelected();
				selectedUnitDept();
				loadEntriesCategory();
				loadPageCategory();
			}
		})
	}

	function loadEntriesCategory(){
	    var page = $("#txtPageCategory").val();
	    var key = $("#txtsearchCat").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_category/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesCategory',
	        success: function(data){
	            $("#txtEntriesCategory").text(data);
	        }
	    });
	}

	function loadPageCategory(){
	    var page = $("#txtPageCategory").val();
	    var key = $("#txtsearchCat").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_category/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageCategory',
	        success: function(data){
	            $("#ulPageCategory").html(data);
	        }
	    });
	}

    function fncPageCatetory(page, pagenums){
        $(".pgnumCategory").removeClass("active");
        $("#pgCategory" + pagenums).addClass("active");
        $("#txtPageCategory").val(page);
        displayCat();
    }

	function catSelected(){
		$("#tblref_merchandisedep_cat tr").each(function(){
			$(this).click(function(){
				$("#tblref_merchandisedep_cat tr").removeClass("selected");
				$(this).addClass("selected");
				selectedCat(this.id);
			})
		})
	}

	function selectedCat(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_category/class.php',
			data: 'id=' + id + '&form=selectedCat',
			success:function(data){
				var arr = data.split("|");
				$("#hiddencatid").val(arr[0]);
				$("#deptId").val(arr[1]).trigger("change");
				$("#catCode").val(arr[2]);
				$("#catDesc").val(arr[3]);
			}
		})
	}

	function clickAddCat(){
		$("#tblref_merchandisedep_cat tr").unbind("click");
		$("#tblref_merchandisedep_cat tr").removeClass("selected");
		$("#buttonsCat").css("display", "none");
		$("#savingbuttonsCat").css("display", "block");
		$(".txtCat").removeAttr("readonly");
		$("#deptId").removeAttr("disabled");
		$("#catclassID").removeAttr("disabled");
		$(".txtCat").val("");
		$("#catclassID").val([]).trigger("change");
		$("#deptId").val([]).trigger("change");
	}

	function cancelbuttonCat(){
		displayCat();
		$("#buttonsCat").css("display", "block");
		$("#savingbuttonsCat").css("display", "none");
		$("#updatebuttonsCat").css("display", "none");
		$(".txtCat").attr("readonly", "readonly");
		$("#deptId").attr("disabled","disabled");
		$("#catclassID").attr("disabled","disabled");
		$(".txtCat").val("");
		$("#catclassID").val([]).trigger("change");
		$("#deptId").val([]).trigger("change");
        $(".txtCat").css("border-color","#D5D5D5");
	}

	function saveCat(){
		var catCode = $("#catCode").val();
		var catDesc = $("#catDesc").val();
		var deptId = $("#deptId").val();
		var classID = $("#catclassID").val();
		var Count = 0;
		$(".txtCat").each(function(){
			if($(this).val() == ""){
                $(this).css("border-color","#f2a696");
                Count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
		})
		if($("#catCode").val() != "" && $("#catDesc").val() != "" <?php if(SysLeaseSetup('isClassification') == "1" && SysLeaseSetup('isDepartment') == "0"){ ?> && classID != "" && classID != null <?php }else { if(SysLeaseSetup('isDepartment') == "1"){ ?> && deptId != "" && deptId != null <?php }} ?>){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/unit_category/class.php',
				data: 'deptId=' + deptId + '&catCode=' + catCode + '&catDesc=' + catDesc + '&classID=' + classID + '&form=saveCat',
				success:function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Category successfully saved.", "cancelbuttonCat", null, "", null, "0");
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

	function clickUpdateCat(){
		var catCode = $("#catCode").val();
		if(catCode == ""){
			setTimeout(function(){
	            showmodal("alert", "Select department first.", "", null, "", null, "1");
	          }, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/unit_category/class.php',
				data: 'catCode=' + catCode + '&form=clickUpdateCat',
				success:function(data){
					if(data == 0){
						$("#tblref_merchandisedep_cat tr").unbind("click");
						$("#buttonsCat").css("display", "none");
						$("#updatebuttonsCat").css("display", "block");
						$(".txtCat").removeAttr("readonly");
						$("#deptId").removeAttr("disabled");
						$("#deptId").removeAttr("readonly");
						$("#catclassID").removeAttr("disabled");
						$("#catclassID").removeAttr("readonly");
					}else{
						$("#tblref_merchandisedep_cat tr").unbind("click");
						$("#buttonsCat").css("display", "none");
						$("#updatebuttonsCat").css("display", "block");
						$("#catDesc").removeAttr("readonly");
						$("#deptId").removeAttr("disabled");
						$("#deptId").removeAttr("readonly");
						$("#catclassID").removeAttr("disabled");
						$("#catclassID").removeAttr("readonly");
					}
				}
			})
		}
	}

	function updateCat(){
		var hiddencatid = $("#hiddencatid").val();
		var catCode = $("#catCode").val();
		var catDesc = $("#catDesc").val();
		var deptId = $("#deptId").val();
		var classID = $("#catclassID").val();
		var Count = 0;
		$(".txtCat").each(function(){
			if($(this).val() == ""){
                $(this).css("border-color","#f2a696");
                Count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
		})
        if($("#catCode").val() != "" && $("#catDesc").val() != "" <?php if(SysLeaseSetup('isClassification') == "1" && SysLeaseSetup('isDepartment') == "0"){ ?> && classID != "" && classID != null <?php }else { if(SysLeaseSetup('isDepartment') == "1"){ ?> && deptId != "" && deptId != null <?php }} ?>){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/unit_category/class.php',
				data: 'deptId=' + deptId + '&hiddencatid=' + hiddencatid + '&catCode=' + catCode + '&catDesc=' + catDesc + '&classID=' + classID + '&form=updateCat',
				success:function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Category successfully updated.", "cancelbuttonCat", null, "", null, "0");
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

	function clickDeleteCat(){
		var catCode = $("#catCode").val();
		var catDesc = $("#catDesc").val();
		var deptId = $("#deptId").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/unit_category/class.php',
			data: 'catCode=' + catCode + '&form=clickUpdateCat',
			success:function(data){
				if(data == 0){
					if(catCode == ""){
						setTimeout(function(){
							showmodal("alert", "Select code first", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("confirm", "Are you sure you want to delete " + catDesc, "clickDeleteCat2", null, "", null, "0");
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

	function clickDeleteCat2(){
		var deptId = $("#deptId").val();
		var catCode = $("#catCode").val();
		var catDesc = $("#catDesc").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_category/class.php',
			data: 'deptId=' + deptId + '&catCode=' + catCode + '&catDesc=' + catDesc + '&form=deleteCat',
			success:function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", catDesc + " has been deleted.", "cancelbuttonCat", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function selectedUnitDept(){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_category/class.php',
			data: 'form=listUnitDept',
			success:function(data){
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
				$("#deptId").html(data);			
			}
		})
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_category/class.php',
			data: 'form=listUnitClass',
			success:function(data){
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
				$("#catclassID").html(data);			
			}
		})
	}

	function AutoConsolidateUnitCategory(){
		var key = $('#txtsearchCat').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_category/class.php',
			data: 'key=' + key + '&form=AutoConsolidateUnitCategory',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of category successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of category.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>