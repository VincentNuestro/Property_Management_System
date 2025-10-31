<script type="text/javascript">
	$(function(){
		blocking();
	});

	setTimeout(function(){
		displayFloor();
	}, 300)

	var countfloorplan = 0;

	function displayFloor2(){
		countfloorplan = 0;
		displayFloor();
	}
	
	function blocking(){
		$("#FloorDesc").on('keypress', function (event) {
        	var regex = new RegExp("^[a-zA-Z!@#$%^*()0-9\s]+$");
        	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    		if (!regex.test(key)) {
   				event.preventDefault();
       			return false;
    		}
     	});
	}

	function displayFloor(){
		var key = $("#txtsearchfloor").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_floorplan/class.php',
			data: 'countfloorplan=' + countfloorplan + '&key=' + key + '&form=displayFloor',
			success: function(data) {
				var arr = data.split("|");
				$("#tblref_floors").html(arr[0]);
				$("#floorcounts").val(arr[1]);
				floorSelected();
				if(arr[1] == 0){
					$("#btn-firstfloorplan").attr("disabled", "disabled");
					$("#btn-prevfloorplan").attr("disabled", "disabled");
					$("#btn-nextfloorplan").attr("disabled", "disabled");
					$("#btn-lastfloorplan").attr("disabled", "disabled");
				}else{
					if(countfloorplan == 0){
						$("#btn-firstfloorplan").attr("disabled", "disabled");
						$("#btn-prevfloorplan").attr("disabled", "disabled");
						$("#btn-nextfloorplan").removeAttr("disabled");
						$("#btn-lastfloorplan").removeAttr("disabled");
					}else if(countfloorplan == $("#floorcounts").val() * 10){
						$("#btn-firstfloorplan").removeAttr("disabled");
						$("#btn-prevfloorplan").removeAttr("disabled");
						$("#btn-nextfloorplan").attr("disabled", "disabled");
						$("#btn-lastfloorplan").attr("disabled", "disabled");
					}else{
						$("#btn-firstfloorplan").removeAttr("disabled");
						$("#btn-prevfloorplan").removeAttr("disabled");
						$("#btn-nextfloorplan").removeAttr("disabled");
						$("#btn-lastfloorplan").removeAttr("disabled");
					}
				}
			}
		})
	}

	function pagefloorplan(txt) {
		if(txt == 'first'){
			countfloorplan = 0;
			displayFloor();
		}else if(txt == "prev"){
			countfloorplan = countfloorplan - 10;
			displayFloor();
		}else if(txt == "next"){
			countfloorplan = countfloorplan + 10;
			displayFloor();
		}else{
			countfloorplan = $("#floorcounts").val() * 10;
			displayFloor();
		}
	}

	function floorSelected(){
		$("#tblref_floors tr").each(function(){
			$(this).click(function(){
				$("#tblref_floors tr").removeClass("selected");
				$(this).addClass("selected");
				selectedFloor(this.id);
			})
		})
	}

	function selectedFloor(id) {
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_floorplan/class.php',
			data: 'id=' + id + '&form=selectedFloor',
			success: function(data) {
				var arr = data.split("|");
				$("#hiddenfloorid").val(arr[0]);
				$("#FloorDesc").val(arr[1]);
			}
		})
	}

	function clickAddFloor(){
		$("#tblref_floors tr").unbind("click");
		$("#tblref_floors tr").removeClass("selected");
		$("#buttonsFloor").css("display", "none");
		$("#savingbuttonsFloor").css("display", "block");
		$(".txtPosition").removeAttr("readonly");
		$(".txtPosition").val("");
	}

	function cancelbuttonFloor(){
		displayFloor();
		$("#buttonsFloor").css("display", "block");
		$("#savingbuttonsFloor").css("display", "none");
		$(".txtPosition").attr("readonly", "readonly");
		$(".txtPosition").val("");
	}

	function cancelbuttonFloor2(){
		displayFloor();
		$("#buttonsFloor").css("display", "block");
		$("#updatebuttonsFloor").css("display", "none");
		$(".txtPosition").attr("readonly", "readonly");
	}

	function saveFloor(){
		var FloorDesc = $("#FloorDesc").val();
		if($("#FloorDesc").val() != ""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/unit_floorplan/class.php',
				data: 'FloorDesc=' + FloorDesc + '&form=saveFloor',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Floor Name successfully saved.", "cancelbuttonFloor", null, "", null, "0");
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

	function clickUpdateFloor(){
		var FloorDesc = $("#FloorDesc").val();
		if(FloorDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select floor name first", "", null, "", null, "1");
			}, 500)
		}else{
			$("#tblref_floors tr").unbind("click");
			$("#buttonsFloor").css("display", "none");
			$("#updatebuttonsFloor").css("display", "block");
			$(".txtPosition").removeAttr("readonly");
		}
	}

	function updateFloor(){
		var hiddenfloorid = $("#hiddenfloorid").val();
		var FloorDesc = $("#FloorDesc").val();
		if(hiddenfloorid != "" && FloorDesc != ""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/unit_floorplan/class.php',
				data: 'hiddenfloorid=' + hiddenfloorid + '&FloorDesc=' + FloorDesc + '&form=updateFloor',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
								showmodal("alert", "Floor Name successfuly updated.", "cancelbuttonFloor2", null, "", null, "0");
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

	function clickDeleteFloor(){
		var FloorDesc = $("#FloorDesc").val();
		if(FloorDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select floor name first", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to delete " + FloorDesc, "clickDeleteFloor2", null, "", null, "0");
			}, 500)
		}
	}

	function clickDeleteFloor2(){
		var hiddenfloorid = $("#hiddenfloorid").val();
		var FloorDesc = $("#FloorDesc").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_floorplan/class.php',
			data: 'hiddenfloorid=' + hiddenfloorid + '&form=deleteFloor',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", FloorDesc + " has been deleted.", "displayFloor", null, "", null, "0");
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