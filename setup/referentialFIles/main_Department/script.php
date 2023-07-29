<script type="text/javascript">
	$(function(){
		$("#txtsearchDepartmentCat").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageMainDepartment").val("1");
				showmainDepartment(); 
			}else if ( x == '8' ){
				if($('#txtsearchDepartmentCat').val() == ""){
					$("#txtPageMainDepartment").val("1");
					showmainDepartment();
				}
			}
		});
	})

	function showmainDepartment(){
		var key = $("#txtsearchDepartmentCat").val();
		var page = $("#txtPageMainDepartment").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_Department/class.php',
			data: 'page=' + page + '&key=' + key + '&form=showmainDepartment',
		success: function(data){
				if(data == ''){
					$("#tblDepartment_category").html("<tr><td colspan='2' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblDepartment_category").html(data);
				}
			}, complete: function(){
				DepartmentCatSelected();
				loadEntriesMainDepartment();
				loadPageMainDepartment();
			}
		})
	}

	function loadEntriesMainDepartment(){
	    var page = $("#txtPageMainDepartment").val();
	    var key = $("#txtsearchDepartmentCat").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/main_Department/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesMainDepartment',
	        success: function(data){
	            $("#txtEntriesMainDepartment").text(data);
	        }
	    });
	}

	function loadPageMainDepartment(){
	    var page = $("#txtPageMainDepartment").val();
	    var key = $("#txtsearchDepartmentCat").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/main_Department/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageMainDepartment',
	        success: function(data){
	            $("#ulPageMainDepartment").html(data);
	        }
	    });
	}

    function fncPageMainDepartment(page, pagenums){
        $(".pgnumHouseRules").removeClass("active");
        $("#pgHouseRules" + pagenums).addClass("active");
        $("#txtPageMainDepartment").val(page);
        showmainHouseRules();
    }

	function DepartmentCatSelected(){
		$("#tblDepartment_category tr").each(function(){
			$(this).click(function(){
				$("#tblDepartment_category tr").removeClass("selected");
				$(this).addClass("selected");
				selectedDepartmentCat(this.id);
			})
		})
	}

	function selectedDepartmentCat(id){
		$("#hiddenDepartmentcatid").val(id);
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/main_Department/class.php',
				data: 'id=' + id + '&form=selectedDepartmentCat',
				success: function(data) {
					var arr = data.split("|");
					$("#DepartmentCatCode").val(arr[0]);
					$("#DepartmentCatDesc").val(arr[1]);
				}
			})
		}

	function clickAddDepartmentCat(){
		$("#tblDepartment_category tr").unbind("click");
		$("#tblDepartment_category tr").removeClass("selected");
		$("#buttonsDepartmentCat").css("display", "none");
		$("#savingbuttonsDepartmentCat").css("display", "block");
		$(".txtDepartmentCat").val("");
		$(".txtDepartmentCat").removeAttr("readonly");
	}

	function cancelbuttonDepartmentCat(){
		showmainDepartment();
		$("#buttonsDepartmentCat").css("display", "block");
		$("#savingbuttonsDepartmentCat").css("display", "none");
		$("#updatebuttonsDepartmentCat").css("display", "none");
		$(".txtDepartmentCat").attr("readonly", "readonly");
		$(".txtDepartmentCat").val("");
	}

	function cancelbuttonDepartmentCat2(){
		showmainDepartment();
		$("#buttonsDepartmentCat").css("display", "block");
		$("#updatebuttonsDepartmentCat").css("display", "none");
		$("#savingbuttonsDepartmentCat").css("display", "none");
		$(".txtDepartmentCat").attr("readonly", "readonly");
	}

	function clickUpdateDepartmentCat(){
		var DepartmentCatCode = $("#DepartmentCatCode").val();
			if(DepartmentCatCode == ""){
				setTimeout(function(){
					showmodal("alert", "Select department first", "", null, "", null, "1");
				}, 500)
			}else if(DepartmentCatDesc == ""){
				setTimeout(function(){
					showmodal("alert", "Select department first", "", null, "", null, "1");
				}, 500);
			}else{
				$.ajax({
					type: 'POST',
					url: 'setup/referentialFiles/main_Department/class.php',
					data: 'DepartmentCatCode=' + DepartmentCatCode + '&form=clickUpdateMainDepartment',
					success:function(data){
						if(data == 0){
							$("#tblDepartment_category tr").unbind("click");
							$("#buttonsDepartmentCat").css("display", "none");
							$("#updatebuttonsDepartmentCat").css("display", "block");
							$(".txtDepartmentCat").removeAttr("readonly");
						}else{
							$("#tblDepartment_category tr").unbind("click");
							$("#buttonsDepartmentCat").css("display", "none");
							$("#updatebuttonsDepartmentCat").css("display", "block");
							$("#DepartmentCatDesc").removeAttr("readonly");
						}
					}
				})
				
			}
	}

	function saveDepartmentCat() {
		var	DepartmentCatCode = $("#DepartmentCatCode").val();
		var	DepartmentCatDesc = $("#DepartmentCatDesc").val();
		if($("#DepartmentCatCode").val() != "" && $("#DepartmentCatDesc").val() != ""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/main_Department/class.php',
				data: 'DepartmentCatCode=' + DepartmentCatCode + '&DepartmentCatDesc=' + DepartmentCatDesc + '&form=saveDepartmentCat',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Saved.", "cancelbuttonDepartmentCat", null, "", null, "0");
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

	function updateDepartmentCat() {
		var	DepartmentCatCode = $("#DepartmentCatCode").val();
		var	DepartmentCatDesc = $("#DepartmentCatDesc").val();
		var id = $("#hiddenDepartmentcatid").val();
		if($("#DepartmentCatCode").val()!="" && $("#DepartmentCatDesc").val()!=""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/main_Department/class.php',
				data: 'DepartmentCatCode=' + DepartmentCatCode + '&DepartmentCatDesc=' + DepartmentCatDesc + '&id=' + id + '&form=updateDepartmentCat',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Saved.", "cancelbuttonDepartmentCat2", null, "", null, "0");
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

	function clickDeleteDepartmentCat() {
		var	DepartmentCatCode = $("#DepartmentCatCode").val();
		var	DepartmentCatDesc = $("#DepartmentCatDesc").val();
		if(DepartmentCatCode == ""){
			setTimeout(function(){
				showmodal("alert", "Select department first", "", null, "", null, "1");
			}, 500)
		}else if(DepartmentCatDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select department first", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to delete " + DepartmentCatDesc, "clickDeleteequipCat2", null, "", null, "0");
			}, 500)
		}
	}

	function clickDeleteDepartmentCat2(){
		var	DepartmentCatCode = $("#DepartmentCatCode").val();
		var	DepartmentCatDesc = $("#DepartmentCatDesc").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_Department/class.php',
			data: 'DepartmentCatCode=' + DepartmentCatCode + '&DepartmentCatDesc=' + DepartmentCatDesc + '&form=clickDeleteDepartmentCat',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", DepartmentCatDesc + " has been deleted.", "showmainDepartment", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function AutoConsolidateDepartment(){
		var key = $('#txtsearchDepartmentCat').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_Department/class.php',
			data: 'key=' + key + '&form=AutoConsolidateDepartment',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of Department successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export List of Department.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>