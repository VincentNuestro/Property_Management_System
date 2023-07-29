<script type="text/javascript">
setTimeout(function() {
	showmainfacilities();
	showfloor2();
	showunit2();
}, 300)

var countmFacilities = 0;

function showmainfacilities2(){
	countmFacilities = 0;
	showmainfacilities();
}

function showmainfacilities(){
	var key = $("#txtsearchfacilitiesCat").val();
	$.ajax({
		type: 'POST',
		url: 'setup/referentialFiles/main_facilities/class.php',
		data: 'countmFacilities=' + countmFacilities + '&key=' + key + '&form=showmainfacilities',
	success:function(data){
			var arr = data.split("|");
			$("#tblfacilities_category").html(arr[0]);
			$("#facilitiescatcounts").val(arr[1]);
			facilitiesCatSelected();
			if(arr[1] == 0){
				$("#btn-firstmFacilities").attr("disabled", "disabled");
				$("#btn-prevmFacilities").attr("disabled", "disabled");
				$("#btn-nextmFacilities").attr("disabled", "disabled");
				$("#btn-lastmFacilities").attr("disabled", "disabled");
			}else{
				if(countmFacilities == 0){
					$("#btn-firstmFacilities").attr("disabled", "disabled");
					$("#btn-prevmFacilities").attr("disabled", "disabled");
					$("#btn-nextmFacilities").removeAttr("disabled");
					$("#btn-lastmFacilities").removeAttr("disabled");
				}else if(countmFacilities == $("#facilitiescatcounts").val() * 10){
					$("#btn-firstmFacilities").removeAttr("disabled");
					$("#btn-prevmFacilities").removeAttr("disabled");
					$("#btn-nextmFacilities").attr("disabled", "disabled");
					$("#btn-lastmFacilities").attr("disabled", "disabled");
				}else{
					$("#btn-firstmFacilities").removeAttr("disabled");
					$("#btn-prevmFacilities").removeAttr("disabled");
					$("#btn-nextmFacilities").removeAttr("disabled");
					$("#btn-lastmFacilities").removeAttr("disabled");
				}
			}
		}
	})
}

function pagemFacilities(txt){
	if(txt == 'first'){
		countmFacilities = 0;
		showmainfacilities();
	}else if(txt == "prev"){
		countmFacilities = countmFacilities - 10;
		showmainfacilities();
	}else if(txt == "next"){
		countmFacilities = countmFacilities + 10;
		showmainfacilities();
	}else{
		countmFacilities = $("#facilitiescatcounts").val() * 10;
		showmainfacilities();
	}
}

function facilitiesCatSelected(){
	$("#tblfacilities_category tr").each(function(){
		$(this).click(function(){
			$("#tblfacilities_category tr").removeClass("selected");
			$(this).addClass("selected");
			selectedfacilitiesCat(this.id);
		})
	})
}

function selectedfacilitiesCat(id){
	$.ajax ({
		type: 'POST',
		url: 'setup/referentialFiles/main_facilities/class.php',
		data: 'id=' + id + '&form=selectedfacilitiesCat',
		success: function(data) {
			var arr = data.split("|");
			$("#facilitiesCatCode").val(arr[0]);
			$("#facilitiesCatDesc").val(arr[1]);
			$("#facilitiesfloor").val(arr[2]);
			$("#facilitiesunit").val(arr[3]);
			$("#facilitiesCatstatus").val(arr[4]);
			$("#hiddenfacilitiescatid").val(arr[5]);
		}
	})
}

function showfloor2(){
	$.ajax({
		type: 'POST',
		url: 'setup/referentialFiles/main_facilities/class.php',
		data: 'form=showfloor',
		success:function(data){
			$("#facilitiesfloor").html(data);
		}
	})
}

function showunit2(){
	$.ajax({
		type: 'POST',
		url: 'mainclass.php',
		data: 'form=tblref_mall',
		success:function(data){
			$("#facilitiesunit").html(data);
		}
	})
}

function clickAddfacilitiesCat(){
	$("#tblfacilities_category tr").unbind("click");
	$("#tblfacilities_category tr").removeClass("selected");
	$("#buttonsfacilitiesCat").css("display", "none");
	$("#savingbuttonsfacilitiesCat").css("display", "block");
	$(".txtfacilitiesCat").removeAttr("readonly");
	$(".txtfacilitiesCat2").attr("disabled", false);
	$(".txtfacilitiesCat").val("");
	$(".txtfacilitiesCat2").val("");
}

function cancelbuttonfacilitiesCat(){
	showmainfacilities();
	$("#buttonsfacilitiesCat").css("display", "block");
	$("#savingbuttonsfacilitiesCat").css("display", "none");
	$("#updatebuttonsfacilitiesCat").css("display", "none");
	$(".txtfacilitiesCat").attr("readonly", "readonly");
	$(".txtfacilitiesCat2").attr("disabled", true);
	$(".txtfacilitiesCat").val("");
	$(".txtfacilitiesCat2").val("");
}

function cancelbuttonfacilitiesCat2(){
	showmainfacilities();
	$("#buttonsfacilitiesCat").css("display", "block");
	$("#updatebuttonsfacilitiesCat").css("display", "none");
	$("#savingbuttonsfacilitiesCat").css("display", "none");
	$(".txtfacilitiesCat").attr("readonly", "readonly");
	$(".txtfacilitiesCat2").attr("disabled", true);
}

function clickUpdatefacilitiesCat(){
	var facilitiesCatCode = $("#facilitiesCatCode").val();
	if(facilitiesCatCode == ""){
		setTimeout(function(){
			showmodal("alert", "Select facility first", "", null, "", null, "1");
		}, 500)
	}else{
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_facilities/class.php',
			data: 'facilitiesCatCode=' + facilitiesCatCode + '&form=clickUpdatefacilitiesCat',
			success: function(data){
				if(data == 0){
					$("#tblfacilities_category tr").unbind("click");
					$("#buttonsfacilitiesCat").css("display", "none");
					$("#updatebuttonsfacilitiesCat").css("display", "block");
					$(".txtfacilitiesCat").removeAttr("readonly");
					$(".txtfacilitiesCat2").attr("disabled", false);
					$("#facilitiesCatCode").removeAttr("readonly");
				}else{
					$("#tblfacilities_category tr").unbind("click");
					$("#buttonsfacilitiesCat").css("display", "none");
					$("#updatebuttonsfacilitiesCat").css("display", "block");
					$(".txtfacilitiesCat").removeAttr("readonly");
					$(".txtfacilitiesCat2").attr("disabled", false);
					$("#facilitiesCatCode").attr("readonly", "readonly");
				}
			}
		})
	}
}

function savefacilitiesCat(){
	var	facilitiesCatCode = $("#facilitiesCatCode").val();
	var	facilitiesCatDesc = $("#facilitiesCatDesc").val();
	var	facilitiesfloor = $("#facilitiesfloor").val();
	var	facilitiesunit = $("#facilitiesunit").val();
	var	facilitiesCatstatus = $("#facilitiesCatstatus").val();
	if($("#facilitiesCatCode").val() != "" && $("#facilitiesCatDesc").val() != "" && $("#facilitiesfloor").val() != "" && $("#facilitiesCatstatus").val() != ""){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_facilities/class.php',
			data: 'facilitiesCatCode=' + facilitiesCatCode + '&facilitiesCatDesc=' + facilitiesCatDesc + '&facilitiesfloor=' + facilitiesfloor + '&facilitiesunit=' + facilitiesunit + '&facilitiesCatstatus=' + facilitiesCatstatus + '&form=savefacilitiesCat',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Facility successfully saved.", "cancelbuttonfacilitiesCat", null, "", null, "0");
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

function updatefacilitiesCat(){
	var	facilitiesCatCode = $("#facilitiesCatCode").val();
	var	facilitiesCatDesc = $("#facilitiesCatDesc").val();
	var	facilitiesfloor = $("#facilitiesfloor").val();
	var	facilitiesunit = $("#facilitiesunit").val();
	var	facilitiesCatstatus = $("#facilitiesCatstatus").val();
	var hiddenfacilitiescatid = $("#hiddenfacilitiescatid").val();
	if($("#facilitiesCatCode").val() != "" && $("#facilitiesCatDesc").val() != "" && $("#facilitiesfloor").val() != "" && $("#facilitiesCatstatus").val() != ""){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_facilities/class.php',
			data: 'facilitiesCatCode=' + facilitiesCatCode + '&facilitiesCatDesc=' + facilitiesCatDesc + '&facilitiesfloor=' + facilitiesfloor + '&facilitiesunit=' + facilitiesunit + '&facilitiesCatstatus=' + facilitiesCatstatus + '&hiddenfacilitiescatid=' + hiddenfacilitiescatid + '&form=updatefacilitiesCat',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Facility successfully updated.", "cancelbuttonfacilitiesCat2", null, "", null, "0");
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

function clickDeletefacilitiesCat(){
	var	facilitiesCatCode = $("#facilitiesCatCode").val();
	var	facilitiesCatDesc = $("#facilitiesCatDesc").val();
	$.ajax({
		type: 'POST',
		url: 'setup/referentialFiles/main_facilities/class.php',
		data: 'facilitiesCatCode=' + facilitiesCatCode + '&form=clickUpdatefacilitiesCat',
		success: function(data){
			if(data == 0){
				if(facilitiesCatCode == ""){
					setTimeout(function(){
						showmodal("alert", "Select facility first", "", null, "", null, "1");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("confirm", "Are you sure you want to delete " + facilitiesCatDesc, "clickDeletefacilitiesCat2", null, "", null, "0");
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

function clickDeletefacilitiesCat2(){
	var	facilitiesCatCode = $("#facilitiesCatCode").val();
	var	facilitiesCatDesc = $("#facilitiesCatDesc").val();
	var hiddenfacilitiescatid = $("#hiddenfacilitiescatid").val();
	$.ajax ({
		type: 'POST',
		url: 'setup/referentialFiles/main_facilities/class.php',
		data: 'facilitiesCatCode=' + facilitiesCatCode + '&hiddenfacilitiescatid=' + hiddenfacilitiescatid + '&form=clickDeletefacilitiesCat',
		success: function (data) {
			if ( data == 1 ) {
				setTimeout(function(){
					showmodal("alert", facilitiesCatDesc + " has been deleted.", "showmainfacilities", null, "", null, "0");
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