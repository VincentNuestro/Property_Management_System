<script type="text/javascript">
	$(function(){
		$("#txtPageDepartment").val("1");
		displayDept();
		$("#txtsearchdept").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageDepartment").val("1");
				displayDept(); 
			}else if ( x == '8' ){
				if($('#txtsearchdept').val() == ""){
					$("#txtPageDepartment").val("1");
					displayDept();
				}
			}
		});

			$(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).removeClass("fa-sort-up").addClass("fa-sort-down");
						$("#UnitDepartmentSortType").val("ASC");
						$("#UnitDepartmentSortBy").val(this.id);
						displayDept();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).removeClass("fa-sort-down").addClass("fa-sort-up");
						$("#UnitDepartmentSortType").val("DESC");
						$("#UnitDepartmentSortBy").val(this.id);
						displayDept();
					}else if($(this).hasClass("fa-sort")){
						$(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#UnitDepartmentSortType").val() == "ASC"){
							$(this).removeClass("fa-sort-down").addClass("fa-sort-up");
							$("#UnitDepartmentSortType").val("DESC");
							$("#UnitDepartmentSortBy").val(this.id);
							displayDept();
						}else{
							$(this).removeClass("fa-sort-up").addClass("fa-sort-down");
							$("#UnitDepartmentSortType").val("ASC");
							$("#UnitDepartmentSortBy").val(this.id);
							displayDept();
						}
					}
				});
			// });
		});
	});

	function displayDept(){
		var UnitDepartmentSortBy = $('#UnitDepartmentSortBy').val();
		var UnitDepartmentSortType = $('#UnitDepartmentSortType').val();
	    var page = $("#txtPageDepartment").val();
		var key = $("#txtsearchdept").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_department/class.php',
			data: 'page=' + page + '&key=' + key + '&UnitDepartmentSortBy=' + UnitDepartmentSortBy + '&UnitDepartmentSortType=' + UnitDepartmentSortType + '&form=displayDept',
			success: function(data) {
				// alert(data);
				if(data == ''){
					$("#tblref_merchandise_depa").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_merchandise_depa").html(data);
				}
			}, complete: function(){
				deptSelected();
				loadEntriesDepartment();
				loadPageDepartment();
			}
		})
	}

	function loadEntriesDepartment(){
	    var page = $("#txtPageDepartment").val();
	    var key = $("#txtsearchdept").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_department/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesDepartment',
	        success: function(data){
	            $("#txtEntriesDepartment").text(data);
	        }
	    });
	}

	function loadPageDepartment(){
	    var page = $("#txtPageDepartment").val();
	    var key = $("#txtsearchdept").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_department/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageDepartment',
	        success: function(data){
	            $("#ulPageDepartment").html(data);
	        }
	    });
	}

    function fncPageDepartment(page, pagenums){
        $(".pgnumDepartment").removeClass("active");
        $("#pgDepartment" + pagenums).addClass("active");
        $("#txtPageDepartment").val(page);
        displayDept();
    }

	function deptSelected(){
		$("#tblref_merchandise_depa tr").each(function(){
			$(this).click(function(){
				$("#tblref_merchandise_depa tr").removeClass("selected");
				$(this).addClass("selected");
				selectedDept(this.id);
			})
		})
	}

	function selectedDept(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_department/class.php',
			data: 'id=' + id + '&form=selectedDept',
			success: function(data) {
				var arr = data.split("|");
				$("#hiddendeptid").val(arr[0]);
				$("#depclassId").val(arr[1]).trigger("change");
				$("#deptCode").val(arr[2]);
				$("#deptDesc").val(arr[3]);
			}
		})
	}

	function clickAddDept(){
		$("#tblref_merchandise_depa tr").unbind("click");
		$("#tblref_merchandise_depa tr").removeClass("selected");
		$("#buttonsDept").css("display", "none");
		$("#savingbuttonsDept").css("display", "block");
		$(".txtDept").removeAttr("readonly");
		$("#depclassId").removeAttr("disabled");
		$(".txtDept").val("");
		selectedClassification();
		$("#depclassId").val([]).trigger("change");
	}

	function cancelbuttonDept(){
		displayDept();
		$("#buttonsDept").css("display", "block");
		$("#savingbuttonsDept").css("display", "none");
		$("#updatebuttonsDept").css("display", "none");
		$(".txtDept").attr("readonly", "readonly");
		$("#depclassId").attr("disabled","disabled");
		$(".txtDept").val("");
        $(".txtDept").css("border-color","#D5D5D5");
        $("#depclassId").val([]).trigger("change");
	}

	function saveDept(){
		var deptCode = $("#deptCode").val();
		var deptDesc = $("#deptDesc").val();
		var depclassId = $("#depclassId").val();
		var Count = 0;
		$(".txtDept").each(function(){
			if($(this).val() == ""){
                $(this).css("border-color","#f2a696");
                Count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
		})
		if(deptCode != "" && deptDesc != "" <?php if(SysLeaseSetup('isClassification') == "1"){ ?> && depclassId != "" && depclassId != null <?php } ?>){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/unit_department/class.php',
				data: 'depclassId=' + depclassId + '&deptCode=' + deptCode + '&deptDesc=' + deptDesc + '&form=saveDept',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Department successfully saved.", "cancelbuttonDept", null, "", null, "0");
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

	function clickUpdateDept(){
		selectedClassification();
		var deptCode = $("#deptCode").val();
		if(deptCode == ""){
			setTimeout(function(){
	            showmodal("alert", "Select department first.", "", null, "", null, "1");
	        }, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/unit_department/class.php',
				data: 'deptCode=' + deptCode + '&form=clickUpdateDept',
				success:function(data){
					if(data == 0){
						$("#tblref_merchandise_depa tr").unbind("click");
						$("#buttonsDept").css("display", "none");
						$("#updatebuttonsDept").css("display", "block");
						$(".txtDept").removeAttr("readonly");
						$("#depclassId").removeAttr("disabled");
					}else{
						$("#tblref_merchandise_depa tr").unbind("click");
						$("#buttonsDept").css("display", "none");
						$("#updatebuttonsDept").css("display", "block");
						$("#deptDesc").removeAttr("readonly");
						$("#depclassId").removeAttr("disabled");
					}
				}
			})			
		}
	}

	function updateDept(){
		var hiddendeptid = $("#hiddendeptid").val();
		var deptCode = $("#deptCode").val();
		var deptDesc = $("#deptDesc").val();
		var depclassId = $("#depclassId").val();
		var Count = 0;
		$(".txtDept").each(function(){
			if($(this).val() == ""){
                $(this).css("border-color","#f2a696");
                Count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
		})
		if($("#deptCode").val() != "" && $("#deptDesc").val() != "" <?php if(SysLeaseSetup('isClassification') == "1"){ ?> && depclassId != "" && depclassId != null <?php } ?>){			
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/unit_department/class.php',
				data: 'depclassId=' + depclassId + '&hiddendeptid=' + hiddendeptid + '&deptCode=' + deptCode + '&deptDesc=' + deptDesc + '&form=updateDept',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Department successfully updated.", "cancelbuttonDept", null, "", null, "0");
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

	function clickDeleteDept(){
		var deptCode = $("#deptCode").val();
		var deptDesc = $("#deptDesc").val();
		var depclassId = $("#depclassId").val();
		$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/unit_department/class.php',
				data: 'deptCode=' + deptCode + '&form=clickUpdateDept',
				success:function(data){
					if(data == 0){
						if(deptCode == ""){
							setTimeout(function(){
								showmodal("alert", "Select code first", "", null, "", null, "1");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("confirm", "Are you sure you want to delete " + deptDesc, "clickDeleteDept2", null, "", null, "0");
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

	function clickDeleteDept2(){
		var deptCode = $("#deptCode").val();
		var deptDesc = $("#deptDesc").val();
		var depclassId = $("#depclassId").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_department/class.php',
			data: 'depclassId=' + depclassId + '&deptCode=' + deptCode + '&deptDesc=' + deptDesc + '&form=deleteClass',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", deptDesc + " has been deleted.", "cancelbuttonDept", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function selectedClassification(){
		var depclassId = $("#depclassId").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_department/class.php',
			data: 'depclassId=' + depclassId + '&form=listClassification',
			success: function(data) {
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
				$("#depclassId").html(data);			
			}
		})
	}

	function AutoConsolidateDepartmentunit(){
		var key = $('#txtsearchdept').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_department/class.php',
			data: 'key=' + key + '&form=AutoConsolidateDepartmentunit',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of department successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of department.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>