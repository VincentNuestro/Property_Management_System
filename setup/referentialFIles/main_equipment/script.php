<script type="text/javascript">
setTimeout(function() {
	showmainequip();
	showfloor();
	showunit();
}, 300)

var countEquipment = 0;

function showmainequip2(){
	countEquipment = 0;
	showmainequip();
}

function showmainequip(){
	var key = $("#txtsearchequipCat").val();
	$.ajax({
		type: 'POST',
		url: 'setup/referentialFiles/main_equipment/class.php',
		data: 'countEquipment=' + countEquipment + '&key=' + key + '&form=showmainequip',
		success:function(data){
			var arr = data.split("|");
			$("#tblequipment_category").html(arr[0]);
			$("#equipcatcounts").val(arr[1]);
			equipCatSelected();
			if(arr[1] == 0){
				$("#btn-firstEquipment").attr("disabled", "disabled");
				$("#btn-prevEquipment").attr("disabled", "disabled");
				$("#btn-nextEquipment").attr("disabled", "disabled");
				$("#btn-lastEquipment").attr("disabled", "disabled");
			}else{
				if(countEquipment == 0){
					$("#btn-firstEquipment").attr("disabled", "disabled");
					$("#btn-prevEquipment").attr("disabled", "disabled");
					$("#btn-nextEquipment").removeAttr("disabled");
					$("#btn-lastEquipment").removeAttr("disabled");
				}else if(countEquipment == $("#equipcatcounts").val() * 10){
					$("#btn-firstEquipment").removeAttr("disabled");
					$("#btn-prevEquipment").removeAttr("disabled");
					$("#btn-nextEquipment").attr("disabled", "disabled");
					$("#btn-lastEquipment").attr("disabled", "disabled");
				}else{
					$("#btn-firstEquipment").removeAttr("disabled");
					$("#btn-prevEquipment").removeAttr("disabled");
					$("#btn-nextEquipment").removeAttr("disabled");
					$("#btn-lastEquipment").removeAttr("disabled");
				}
			}
		}
	})
}

function pageEquipment(txt){
	if(txt == 'first'){
		countEquipment = 0;
		showmainequip();
	}else if(txt == "prev"){
		countEquipment = countEquipment - 10;
		showmainequip();
	}else if(txt == "next"){
		countEquipment = countEquipment + 10;
		showmainequip();
	}else{
		countEquipment = $("#equipcatcounts").val() * 10;
		showmainequip();
	}
}

function equipCatSelected(){
	$("#tblequipment_category tr").each(function(){
		$(this).click(function(){
			$("#tblequipment_category tr").removeClass("selected");
			$(this).addClass("selected");
			selectedequipCat(this.id);
		})
	})
}

function selectedequipCat(id){
	$.ajax ({
		type: 'POST',
		url: 'setup/referentialFiles/main_equipment/class.php',
		data: 'id=' + id + '&form=selectedequipCat',
		success: function(data) {
			var arr = data.split("|");
			$("#equipCatCode").val(arr[0]);
			$("#equipCatDesc").val(arr[1]);
			$("#eqfloor").val(arr[2]);
			$("#equnit").val(arr[3]);
			$("#equipCatstatus").val(arr[4]);
			$("#hiddenequipcatid").val(arr[5]);
		}
	})
}

function showfloor(){
	$.ajax({
		type: 'POST',
		url: 'setup/referentialFiles/main_equipment/class.php',
		data: 'form=showfloor',
		success:function(data){
			$("#eqfloor").html(data);
		}
	})
}

function showunit(){
	$.ajax({
		type: 'POST',
		url: 'mainclass.php',
		data: 'form=tblref_mall',
		success:function(data){
			$("#equnit").html(data);
		}
	})
}

function clickAddequipCat(){
	$("#tblequipment_category tr").unbind("click");
	$("#tblequipment_category tr").removeClass("selected");
	$("#buttonsequipCat").css("display", "none");
	$("#savingbuttonsequipCat").css("display", "block");
	$(".txtequipCat").removeAttr("readonly");
	$(".txtequipCat2").attr("disabled", false);
	$(".txtequipCat").val("");
	$(".txtequipCat2").val("");
}

function cancelbuttonequipCat(){
	showmainequip();
	$("#buttonsequipCat").css("display", "block");
	$("#savingbuttonsequipCat").css("display", "none");
	$("#updatebuttonsequipCat").css("display", "none");
	$(".txtequipCat").attr("readonly", "readonly");
	$(".txtequipCat2").attr("disabled", true);
	$(".txtequipCat").val("");
	$(".txtequipCat2").val("");
}

function cancelbuttonequipCat2(){
	showmainequip();
	$("#buttonsequipCat").css("display", "block");
	$("#updatebuttonsequipCat").css("display", "none");
	$("#savingbuttonsequipCat").css("display", "none");
	$(".txtequipCat").attr("readonly", "readonly");
	$(".txtequipCat2").attr("disabled", true);
}

function clickUpdateequipCat(){
	var equipCatCode = $("#equipCatCode").val();
	var equipCatDesc = $("#equipCatDesc").val();
	if(equipCatCode == ""){
		setTimeout(function(){
			showmodal("alert", "Select equipment first", "", null, "", null, "1");
		}, 500)
	}else if(equipCatDesc == ""){
		setTimeout(function(){
			showmodal("alert", "Select equipment first", "", null, "", null, "1");
		}, 500)
	}else{
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_equipment/class.php',
			data: 'equipCatCode=' + equipCatCode + '&form=clickUpdateequipCat',
			success:function(data){
				if(data == 0){
					$("#tblequipment_category tr").unbind("click");
					$("#buttonsequipCat").css("display", "none");
					$("#updatebuttonsequipCat").css("display", "block");
					$(".txtequipCat").removeAttr("readonly");
					$(".txtequipCat2").attr("disabled", false);
				}else{
					$("#tblequipment_category tr").unbind("click");
					$("#buttonsequipCat").css("display", "none");
					$("#updatebuttonsequipCat").css("display", "block");
					$(".txtequipCat").removeAttr("readonly");
					$(".txtequipCat2").attr("disabled", false);
					$("#equipCatCode").attr("readonly", "readonly");
				}
			}
		})
	}
}

function saveequipCat(){
	var	equipCatCode = $("#equipCatCode").val();
	var	equipCatDesc = $("#equipCatDesc").val();
	var	eqfloor = $("#eqfloor").val();
	var	equnit = $("#equnit").val();
	var	equipCatstatus = $("#equipCatstatus").val();
	if($("#equipCatCode").val() != "" && $("#equipCatDesc").val() != "" && $("#eqfloor").val() != "" && $("#equipCatstatus").val() != ""){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_equipment/class.php',
			data: 'equipCatCode=' + equipCatCode + '&equipCatDesc=' + equipCatDesc + '&eqfloor=' + eqfloor + '&equnit=' + equnit + '&equipCatstatus=' + equipCatstatus + '&form=saveequipCat',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Equipment successfully saved.", "cancelbuttonequipCat", null, "", null, "0");
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

function updateequipCat(){
	var	equipCatCode = $("#equipCatCode").val();
	var	equipCatDesc = $("#equipCatDesc").val();
	var	eqfloor = $("#eqfloor").val();
	var	equnit = $("#equnit").val();
	var	equipCatstatus = $("#equipCatstatus").val();
	var hiddenideqid = $("#hiddenequipcatid").val();
	if($("#equipCatCode").val() != "" && $("#equipCatDesc").val() != "" && $("#eqfloor").val() != "" && $("#equipCatstatus").val() != ""){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_equipment/class.php',
			data: 'hiddenideqid=' + hiddenideqid + '&equipCatCode=' + equipCatCode + '&equipCatDesc=' + equipCatDesc + '&eqfloor=' + eqfloor + '&equnit=' + equnit + '&equipCatstatus=' + equipCatstatus + '&form=updateequipCat',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Equipment successfully updated.", "cancelbuttonequipCat2", null, "", null, "0");
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

function clickDeleteequipCat(){
	var	equipCatCode = $("#equipCatCode").val();
	var	equipCatDesc = $("#equipCatDesc").val();
	$.ajax({
		type: 'POST',
		url: 'setup/referentialFiles/main_equipment/class.php',
		data: 'equipCatCode=' + equipCatCode + '&form=clickUpdateequipCat',
		success:function(data){
			if(data == 0){
				if(equipCatCode == "" ){
					setTimeout(function(){
						showmodal("alert", "Select equipment first", "", null, "", null, "1");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("confirm", "Are you sure you want to delete " + equipCatDesc, "clickDeleteequipCat2", null, "", null, "0");
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

function clickDeleteequipCat2(){
	var	equipCatCode = $("#equipCatCode").val();
	var	equipCatDesc = $("#equipCatDesc").val();
	var hiddenideqid = $("#hiddenequipcatid").val();
	$.ajax ({
		type: 'POST',
		url: 'setup/referentialFiles/main_equipment/class.php',
		data: 'equipCatCode=' + equipCatCode + '&hiddenideqid=' + hiddenideqid + '&form=clickDeleteequipCat',
		success: function (data) {
			if(data == 1){
				setTimeout(function(){
					showmodal("alert", equipCatDesc + " has been deleted.", "showmainequip", null, "", null, "0");
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