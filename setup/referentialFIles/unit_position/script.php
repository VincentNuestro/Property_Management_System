<script type="text/javascript">
	$(function(){
		$("#txtsearchposition").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPagePosition").val("1");
				displayPosition(); 
			}else if ( x == '8' ){
				if($('#txtsearchposition').val() == ""){
					$("#txtPagePosition").val("1");
					displayPosition();
				}
			}
		});
	});

	function displayPosition() {
		var key = $("#txtsearchposition").val();
	    var page = $("#txtPagePosition").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_position/class.php',
			data: 'page=' + page + '&key=' + key + '&form=displayPosition',
			success: function(data) {
				if(data == ''){
					$("#tblref_companyposition").html("<tr><td style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblref_companyposition").html(data);
				}
			}, complete: function(){
				positionSelected();
				loadEntriesBPosition();
				loadPagePosition();
				showDepartment();
			}
		})
	}

	function loadEntriesBPosition(){
	    var page = $("#txtPagePosition").val();
	    var key = $("#txtsearchposition").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_position/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesPosition',
	        success: function(data){
	            $("#txtEntriesPosition").text(data);
	        }
	    });
	}

	function loadPagePosition(){
	    var page = $("#txtPagePosition").val();
	    var key = $("#txtsearchposition").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/unit_position/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPagePosition',
	        success: function(data){
	            $("#ulPagePosition").html(data);
	        }
	    });
	}

    function fncPagePosition(page, pagenums){
        $(".pgnumPosition").removeClass("active");
        $("#pgPosition" + pagenums).addClass("active");
        $("#txtPagePosition").val(page);
        displayPosition();
    }

	function positionSelected() {
		$("#tblref_companyposition tr").each(function(){
			$(this).click(function(){
				$("#tblref_companyposition tr").removeClass("selected");
				$(this).addClass("selected");
				selectedPosition(this.id);
				showDepartment();
			})
		})
	}
// ruth
	function selectedPosition(id) {
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_position/class.php',
			data: 'id=' + id + '&form=selectedPosition',
			success: function(data) {
				var arr = data.split("|");
				$("#hiddenpositionid").val(arr[0]);
				$("#positionCode").val(arr[2]);
				$("#positionDesc").val(arr[3]);
				$("#deptdesc").val(arr[1]).trigger("change");
			}
		})
	}
// ruth
	function clickAddPosition() {
		$("#tblref_companyposition tr").unbind("click");
		$("#tblref_companyposition tr").removeClass("selected");
		$("#buttonsPosition").css("display", "none");
		$("#savingbuttonsPosition").css("display", "block");
		$(".txtPosition").removeAttr("readonly");
		$(".txtPosition").val("");
		$("#deptdesc").removeAttr("disabled");
		$("#deptdesc").val("");
		showDepartment();

	}
// ruth
	function cancelbuttonPosition() {
		displayPosition();
		$("#buttonsPosition").css("display", "block");
		$("#savingbuttonsPosition").css("display", "none");
		$(".txtPosition").attr("readonly", "readonly");
		$(".txtPosition").val("");
		$("#deptdesc").attr("disabled", true);
	}

	function cancelbuttonPosition2() {
		displayPosition();
		$("#buttonsPosition").css("display", "block");
		$("#updatebuttonsPosition").css("display", "none");
		$(".txtPosition").attr("readonly", "readonly");
		$("#deptdesc").attr("disabled", true);
	}

	function savePosition() {
		var PositionCode = $("#positionCode").val();
		var positionDesc = $("#positionDesc").val();
		var deptdesc = $("#deptdesc").val();
        if($("#PositionCode").val() != ""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/unit_position/class.php',
				data: 'PositionCode=' + PositionCode + '&positionDesc=' + positionDesc + '&deptdesc=' + deptdesc + '&form=savePosition',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Position successfully saved.", "cancelbuttonPosition", null, "", null, "0");
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

	function clickUpdatePosition() {
		var positionDesc = $("#positionDesc").val();
		if(positionDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select position first", "", null, "", null, "1");
			}, 500)
		}else{
			$("#tblref_companyposition tr").unbind("click");
			$("#buttonsPosition").css("display", "none");
			$("#updatebuttonsPosition").css("display", "block");
			$(".txtPosition").removeAttr("readonly");
			$("#deptdesc").removeAttr("disabled");
		}
	}

	function updatePosition() {
		var hiddenpositionid = $("#hiddenpositionid").val();
		var PositionCode = $("#positionCode").val();
		var positionDesc = $("#positionDesc").val();
		var deptdesc = $("#deptdesc").val();
		if($("#positionDesc").val() != ""){
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/unit_position/class.php',
				data: 'PositionCode=' + PositionCode + '&deptdesc=' + deptdesc + '&hiddenpositionid=' + hiddenpositionid + '&positionDesc=' + positionDesc + '&form=updatePosition',
				success: function (data) {
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Position successfully updated.", "cancelbuttonPosition2", null, "", null, "0");
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
	            showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
	        }, 500)
		}
	}

	function clickDeletePosition() {
		var positionDesc = $("#positionDesc").val();
		if(positionDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select position first", "", null, "", null, "1");
			}, 500)
		}else{
			setTimeout(function(){
				showmodal("confirm", "Are you sure you want to delete " + positionDesc, "clickDeletePosition2", null, "", null, "0");
			}, 500)
		}
	}

	function clickDeletePosition2(){
		var hiddenpositionid = $("#hiddenpositionid").val();
		var positionDesc = $("#positionDesc").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_position/class.php',
			data: 'hiddenpositionid=' + hiddenpositionid + '&form=deletePosition',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", positionDesc + " has been deleted.", "displayPosition", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function showDepartment(){
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/unit_position/class.php',
			data: 'form=showDepartment',
			success:function(data){
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
				$("#deptdesc").html(data);
			}
		})
	}

	function AutoConsolidatePosition(){
		var key = $('#txtsearchposition').val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/unit_position/class.php',
			data: 'key=' + key + '&form=AutoConsolidatePosition',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "List of position successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export list of position.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}
</script>