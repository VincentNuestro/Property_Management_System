<script type="text/javascript">
setTimeout(function() {
	showmainscse();
	showfloor3();
	showunit3();
}, 300)

var countscse = 0;

function showmainscse2(){
	countscse = 0;
	showmainscse();
}

function showmainscse(){
	var key = $("#txtsearchscseCat").val();
	$.ajax({
		type: 'POST',
		url: 'setup/referentialFiles/main_SCSE/class.php',
		data: 'countscse=' + countscse + '&key=' + key + '&form=showmainscse',
	success:function(data){
			var arr = data.split("|");
			$("#tblSCSE_category").html(arr[0]);
			$("#scsecatcounts").val(arr[1]);
			scseCatSelected();
			if(arr[1] == 0){
				$("#btn-firstscse").attr("disabled", "disabled");
				$("#btn-prevscse").attr("disabled", "disabled");
				$("#btn-nextscse").attr("disabled", "disabled");
				$("#btn-lastscse").attr("disabled", "disabled");
			}else{
				if(countscse == 0){
					$("#btn-firstscse").attr("disabled", "disabled");
					$("#btn-prevscse").attr("disabled", "disabled");
					$("#btn-nextscse").removeAttr("disabled");
					$("#btn-lastscse").removeAttr("disabled");
				}else if(countscse == $("#scsecatcounts").val() * 10){
					$("#btn-firstscse").removeAttr("disabled");
					$("#btn-prevscse").removeAttr("disabled");
					$("#btn-nextscse").attr("disabled", "disabled");
					$("#btn-lastscse").attr("disabled", "disabled");
				}else{
					$("#btn-firstscse").removeAttr("disabled");
					$("#btn-prevscse").removeAttr("disabled");
					$("#btn-nextscse").removeAttr("disabled");
					$("#btn-lastscse").removeAttr("disabled");
				}
			}
		}
	})
}

function pagescse(txt){
	if(txt == 'first'){
		countscse = 0;
		showmainscse();
	}else if(txt == "prev"){
		countscse = countscse - 10;
		showmainscse();
	}else if(txt == "next"){
		countscse = countscse + 10;
		showmainscse();
	}else{
		countscse = $("#maincatcounts").val() * 10;
		showmainscse();
	}
}

function scseCatSelected(){
	$("#tblSCSE_category tr").each(function(){
		$(this).click(function(){
			$("#tblSCSE_category tr").removeClass("selected");
			$(this).addClass("selected");
			selectedscseCat(this.id);
		})
	})
}

function selectedscseCat(id){
	$.ajax ({
		type: 'POST',
		url: 'setup/referentialFiles/main_SCSE/class.php',
		data: 'id=' + id + '&form=selectedscseCat',
		success: function(data) {
			var arr = data.split("|");
			$("#scseCatCode").val(arr[0]);
			$("#scseCatDesc").val(arr[1]);
			$("#scsefloor").val(arr[2]);
			$("#scseunit").val(arr[3]);
			$("#scseCatstatus").val(arr[4]);
			$("#hiddenscsecatid").val(arr[5]);
		}
	})
}

function showfloor3(){
	$.ajax({
		type: 'POST',
		url: 'setup/referentialFiles/main_SCSE/class.php',
		data: 'form=showfloor',
	success:function(data){
			$("#scsefloor").html(data);
		}
	})
}

function showunit3(){
	$.ajax({
		type: 'POST',
		url: 'mainclass.php',
		data: 'form=tblref_mall',
	success:function(data){
			$("#scseunit").html(data);
		}
	})
}

function clickAddscseCat(){
	$("#tblSCSE_category tr").unbind("click");
	$("#tblSCSE_category tr").removeClass("selected");
	$("#buttonsscseCat").css("display", "none");
	$("#savingbuttonsscseCat").css("display", "block");
	$(".txtscseCat").removeAttr("readonly");
	$(".txtscseCat2").attr("disabled", false);
	$(".txtscseCat").val("");
	$(".txtscseCat2").val("");
}

function cancelbuttonscseCat(){
	showmainscse();
	$("#buttonsscseCat").css("display", "block");
	$("#savingbuttonsscseCat").css("display", "none");
	$("#updatebuttonsscseCat").css("display", "none");
	$(".txtscseCat").attr("readonly", "readonly");
	$(".txtscseCat2").attr("disabled", true);
	$(".txtscseCat").val("");
	$(".txtscseCat2").val("");
}

function cancelbuttonscseCat2(){
	showmainscse();
	$("#buttonsscseCat").css("display", "block");
	$("#updatebuttonsscseCat").css("display", "none");
	$("#savingbuttonsscseCat").css("display", "none");
	$(".txtscseCat").attr("readonly", "readonly");
	$(".txtscseCat2").attr("disabled", true);
}

function clickUpdatescseCat(){
	var scseCatCode = $("#scseCatCode").val();
	if(scseCatCode == ""){
		setTimeout(function(){
			showmodal("alert", "Select code first", "", null, "", null, "1");
		}, 500)
	}else{
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_SCSE/class.php',
			data: 'scseCatCode=' + scseCatCode + '&form=clickUpdatescseCat',
			success: function(data){
				if(data == 0){
					$("#tblSCSE_category tr").unbind("click");
					$("#buttonsscseCat").css("display", "none");
					$("#updatebuttonsscseCat").css("display", "block");
					$(".txtscseCat").removeAttr("readonly");
					$(".txtscseCat2").attr("disabled", false);
					$("#scseCatCode").removeAttr("readonly");
				}else{
					$("#tblSCSE_category tr").unbind("click");
					$("#buttonsscseCat").css("display", "none");
					$("#updatebuttonsscseCat").css("display", "block");
					$(".txtscseCat").removeAttr("readonly");
					$(".txtscseCat2").attr("disabled", false);
					$("#scseCatCode").attr("readonly", "readonly");
				}
			}
		})
	}
}

function savescseCat(){
	var	scseCatCode = $("#scseCatCode").val();
	var	scseCatDesc = $("#scseCatDesc").val();
	var	scsefloor = $("#scsefloor").val();
	var	scseunit = $("#scseunit").val();
	var	scseCatstatus = $("#scseCatstatus").val();
	var hiddenscsecatid = $("#hiddenscsecatid").val();
	if($("#scseCatCode").val() != "" && $("#scseCatDesc").val() != "" && $("#scsefloor").val() != "" && $("#scseCatstatus").val() != "") {
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_SCSE/class.php',
			data: 'scseCatCode=' + scseCatCode + '&scseCatDesc=' + scseCatDesc + '&scsefloor=' + scsefloor + '&scseunit=' + scseunit + '&scseCatstatus=' + scseCatstatus + '&hiddenscsecatid=' + hiddenscsecatid + '&form=savescseCat',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Security and Communication System Equipment successfully saved.", "cancelbuttonscseCat", null, "", null, "0");
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

function updatescseCat() {
	var	scseCatCode = $("#scseCatCode").val();
	var	scseCatDesc = $("#scseCatDesc").val();
	var	scsefloor = $("#scsefloor").val();
	var	scseunit = $("#scseunit").val();
	var	scseCatstatus = $("#scseCatstatus").val();
	var hiddenscsecatid = $("#hiddenscsecatid").val();
	if($("#scseCatCode").val() != "" && $("#scseCatDesc").val() != "" && $("#scsefloor").val() != "" && $("#scseCatstatus").val() != "") {
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_SCSE/class.php',
			data: 'scseCatCode=' + scseCatCode + '&scseCatDesc=' + scseCatDesc + '&scsefloor=' + scsefloor + '&scseunit=' + scseunit + '&scseCatstatus=' + scseCatstatus + '&hiddenscsecatid=' + hiddenscsecatid + '&form=updatescseCat',
			success: function(data){
				if(data == 1){
					showmodal("alert", "Security and Communication System Equipment successfully updated.", "cancelbuttonscseCat2", null, "", null, "0");
				}else{
					showmodal("alert", data, "", null, "", null, "0");
				}
			}
		})
	}else{
		setTimeout(function(){
			showmodal("alert", "Please fill all fields", "", null, "", null, "1");
		}, 500)
	}
}

function clickDeletescseCat(){
	var	scseCatCode = $("#scseCatCode").val();
	var	scseCatDesc = $("#scseCatDesc").val();
	$.ajax({
		type: 'POST',
		url: 'setup/referentialFiles/main_SCSE/class.php',
		data: 'scseCatCode=' + scseCatCode + '&form=clickUpdatescseCat',
		success: function(data){
			if(data == 0){
				if(scseCatCode == ""){
					setTimeout(function(){
						showmodal("alert", "Select code first", "", null, "", null, "1");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("confirm", "Are you sure you want to delete " + scseCatDesc, "clickDeletescseCat2", null, "", null, "0");
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

function clickDeletescseCat2(){
	var	scseCatCode = $("#scseCatCode").val();
	var	scseCatDesc = $("#scseCatDesc").val();
	var hiddenscsecatid = $("#hiddenscsecatid").val();
	$.ajax ({
		type: 'POST',
		url: 'setup/referentialFiles/main_SCSE/class.php',
		data: 'hiddenscsecatid=' + hiddenscsecatid + '&scseCatDesc=' + scseCatDesc + '&form=clickDeletescseCat',
		success: function(data){
			if(data == 1){
				setTimeout(function(){
					showmodal("alert", scseCatDesc + " has been deleted.", "showmainscse", null, "", null, "0");
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