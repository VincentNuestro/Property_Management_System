<script type="text/javascript">
	$(function(){
		$(".radFixedPayment").click(function(){
			if($(this).is(":checked")){
				if($(this).attr("id") == "FixedPaymentYes"){
					$("#txtFixedPayment").css("display", "block");
					$("#txtFixedPayment").removeAttr("readonly");
				}else{
					$("#txtFixedPayment").css("display", "none");
					$("#txtFixedPayment").attr("readonly", "readonly");
				}
			}
		})
		$(".numonly").keydown(function(event) {
           	if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9 || event.keyCode == 188) {
            }else{
                if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 17) {
                   event.preventDefault(); 
                }   
            }
       });
		$(".amount").change(function(){
            var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });
        $("#txtsearchMainCat").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtPageMainCat").val("1");
				displayMainCat(); 
			}else if ( x == '8' ){
				if($('#txtsearchMainCat').val() == ""){
					$("#txtPageMainCat").val("1");
					displayMainCat();
				}
			}
		});

		$(function(){
			// $(".btnsortdash").each(function(){
				$('.btnsortdash-maincat').click(function(){
					if($(this).hasClass("fa-sort-up")){
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#MainCatSortType").val("ASC");
						$("#MainCatSortBy").val(this.id);
						displayMainCat();
					}
					else if($(this).hasClass("fa-sort-down")){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#MainCatSortType").val("DESC");
						$("#MainCatSortBy").val(this.id);
						displayMainCat();
					}else if($(this).hasClass("fa-sort")){
						// $(".btnsortdash").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
						if($("#MainCatSortType").val() == "ASC"){
							$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
							$("#MainCatSortType").val("DESC");
							$("#MainCatSortBy").val(this.id);
							displayMainCat();
						}else{
							$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
							$("#MainCatSortType").val("ASC");
							$("#MainCatSortBy").val(this.id);
							displayMainCat();
						}
					}
				});
			// });
		});
	})

	function displayMainCat(){
		var MainCatSortBy = $('#MainCatSortBy').val();
		var MainCatSortType = $('#MainCatSortType').val();
	    var page = $("#txtPageMainCat").val();
		var key = $("#txtsearchMainCat").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_cat/class.php',
			data: 'page=' + page + '&key=' + key + '&MainCatSortBy=' + MainCatSortBy + '&MainCatSortType=' + MainCatSortType + '&form=displayMainCat',
			success: function(data) {
				if(data == ''){
					$("#tblmaintenance_category").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
				}else{
					$("#tblmaintenance_category").html(data);
				}
			}, complete: function(){
				mainCatSelected();
				loadEntriesMainCat();
				loadPageMainCat();
				$(".searchy_select").select2();
                $(".select2-selection").css('height','33px');
			}
		})
	}

	function loadEntriesMainCat(){
	    var page = $("#txtPageMainCat").val();
	    var key = $("#txtsearchMainCat").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/main_cat/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadEntriesMainCat',
	        success: function(data){
	            $("#txtEntriesMainCat").text(data);
	        }
	    });
	}

	function loadPageMainCat(){
	    var page = $("#txtPageMainCat").val();
	    var key = $("#txtsearchMainCat").val();
	    $.ajax({
	        type: 'POST',
			url: 'setup/referentialFiles/main_cat/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=loadPageMainCat',
	        success: function(data){
	            $("#ulPageMainCat").html(data);
	        }
	    });
	}

    function fncPageMainCat(page, pagenums){
        $(".pgnumMainCat").removeClass("active");
        $("#pgMainCat" + pagenums).addClass("active");
        $("#txtPageMainCat").val(page);
        displayMainCat();
    }

	function mainCatSelected(){
		$("#tblmaintenance_category tr").each(function(){
			$(this).click(function(){
				$("#tblmaintenance_category tr").removeClass("selected");
				$(this).addClass("selected");
				selectedMainCat(this.id);
			})
		})
	}

	function selectedMainCat(id){
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_cat/class.php',
			data: 'id=' + id + '&form=selectedMainCat',
			success: function(data) {
				var arr = data.split("|");
				if(arr[2] != "1"){
					$(".IconDiv").css("display", "block");
					$("#imahengmetro").css("display", "inline-block");
					$("#logongupload").css("display", "none");
					$("#textngupload").css("display", "none");
					$("#btnremovephoto").css("display", "none");
				}else{
					$(".IconDiv").css("display", "none");
					$("#imahengmetro").css("display", "none");
					$("#logongupload").css("display", "none");
					$("#textngupload").css("display", "none");
					$("#btnremovephoto").css("display", "none");
				}
				$("#MainCatCode").val(arr[0]);
				$("#MainCatDesc").val(arr[1]);
				$("#imahengmetro").attr("src", arr[2]);
				$("#MainCatType").val(arr[3]).trigger("change");
				if(arr[4] == "Yes"){
					$("#FixedPaymentYes").prop("checked", true);
					$("#FixedPaymentNo").prop("checked", false);
					$("#txtFixedPayment").css("display", "block");
					$("#txtFixedPayment").val(arr[5]);
				}else{
					$("#FixedPaymentYes").prop("checked", false);
					$("#FixedPaymentNo").prop("checked", true);
					$("#txtFixedPayment").css("display", "none");
					$("#txtFixedPayment").val("");
				}
				if(arr[6] == "Yes"){
					$("#AddTaskYes").prop("checked", true);
					$("#AddTaskNo").prop("checked", false);
				}else{
					$("#AddTaskYes").prop("checked", false);
					$("#AddTaskNo").prop("checked", true);
				}
				$("#HiddenMainCatID").val(arr[7]);
				$("#MainCatisReading").val(arr[8]).trigger("change");
			}
		})
	}

	function clickAddMainCat(){
		$("#tblmaintenance_category tr").unbind("click");
		$("#tblmaintenance_category tr").removeClass("selected");
		$("#buttonsMainCat").css("display", "none");
		$("#savingbuttonsMainCat").css("display", "block");
		$(".txtMainCat").removeAttr("readonly");
		$(".txtMainCat").val("");
		$("#MainCatisReading").val("0").trigger("change");
		$("#MainCatType").val([]).trigger("change");
		$(".IconDiv").css("display", "block");
		$("#imahengmetro").css("display", "none");
		$("#txtCatIcon").css("display", "block");
		$("#textngupload").css("display", "block");
		$("#logongupload").css("display", "block");
		$("#btnremovephoto").css("display", "none");
		$(".txtMainCat2").prop("disabled", false);
		$(".txtMainCat2").removeAttr("readonly");
		$(".radFixedPayment").prop("disabled", false);
		$(".radAddtask").prop("disabled", false);
		$("#FixedPaymentNo").click();
		$("#AddTaskNo").click();
		$("#txtFixedPayment").removeAttr("readonly");
		$("#txtFixedPayment").val("");
	}

	function cancelbuttonMainCat(){
		displayMainCat();
		$("#buttonsMainCat").css("display", "block");
		$("#savingbuttonsMainCat").css("display", "none");
		$("#updatebuttonsMainCat").css("display", "none");
		$(".txtMainCat").attr("readonly", "readonly");
		$(".txtMainCat").val("");
		$(".IconDiv").css("display", "none");
		$("#txtCatIcon").css("display", "none");
		$("#textngupload").css("display", "none");
		$("#logongupload").css("display", "none");
		$("#btnremovephoto").css("display", "none");
		$(".txtMainCat2").prop("disabled", true);
		$(".txtMainCat2").removeAttr("readonly");
		$(".radFixedPayment").prop("disabled", true);
		$(".radFixedPayment").prop("checked", false);
		$(".radAddtask").prop("disabled", true);
		$(".radAddtask").prop("checked", false);
		$("#txtFixedPayment").css("display", "none");
		$("#txtFixedPayment").removeAttr("readonly");
		$("#txtFixedPayment").val("");
        $(".txtMainCat").css("border-color","#D5D5D5");
	}

	function saveMainCat(){
		var MainCatCode = $("#MainCatCode").val();
		var MainCatDesc = $("#MainCatDesc").val();
		var MainCatType = $("#MainCatType").val();
		var MainisReading = $("#MainCatisReading").val();
		var isFixed = "";
		var FixedAmount = 0;
		var AddTask = "";
		$(".radFixedPayment").each(function(){
			if($(this).is(":checked")){
				if($(this).attr("id") == "FixedPaymentYes"){
					isFixed = "Yes";
					FixedAmount = $("#txtFixedPayment").val().replace(/,/g,"");
				}else{
					isFixed = "No";
					FixedAmount = 0;
				}
			}
		})
		$(".radAddtask").each(function(){
			if($(this).is(":checked")){
				if($(this).attr("id") == "AddTaskYes"){
					AddTask = "Yes";
				}else{
					AddTask = "No";
				}
			}
		})
		var Count = 0;
		$(".txtMainCat").each(function(){
			if($(this).val() == ""){
                $(this).css("border-color","#f2a696");
                Count++;
            }else{
                $(this).css("border-color","#D5D5D5");
            }
		})
		if((isFixed == "Yes" && FixedAmount == 0) || Count > 0){
			setTimeout(function(){
				showmodal("alert", "Please fill all fields", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax ({
				type: 'POST',
				url: 'setup/referentialFiles/main_cat/class.php',
				data: 'MainCatCode=' + MainCatCode + '&MainCatDesc=' + MainCatDesc + '&MainCatType=' + MainCatType + '&isFixed=' + isFixed + '&FixedAmount=' + FixedAmount + '&AddTask=' + AddTask + '&MainisReading=' + MainisReading + '&form=saveMainCat',
				success: function(data){
					var arr = data.split("|");
					if(arr[0] == 1){
						setTimeout(function(){
							showmodal("alert", "Maintenance Category successfully saved.", "cancelbuttonMainCat", null, "", null, "0");
						}, 500)
						hiddenpangupload54(arr[1]);
					}else{
						setTimeout(function(){
							showmodal("alert", data, "", null, "", null, "1");
						}, 500)
					}
				}
			})
		}
	}

	function clickUpdateMainCat(){
		var MainCatCode = $("#MainCatCode").val();
		var image = $("#imahengmetro").attr("src");
		if(image != "1"){
			$("#btnremovephoto").css("display", "block");
		}else{
			$("#imahengmetro").css("display", "none");
			$("#logongupload").css("display", "block");
			$("#textngupload").css("display", "block");
			$("#txtCatIcon").css("display", "block");
			$(".IconDiv").css("display", "block");
			$("#btnremovephoto").css("display", "none");
		}
		if(MainCatCode == ""){
			setTimeout(function(){
				showmodal("alert", "Select category first", "", null, "", null, "1");
			}, 500)
		}else if(MainCatDesc == ""){
			setTimeout(function(){
				showmodal("alert", "Select category first", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/referentialFiles/main_cat/class.php',
				data: 'MainCatCode=' + MainCatCode + '&form=clickUpdateMainCat',
				success:function(data){
					var arr = data.split("|");
					if(arr[0] == 0){
						$("#tblmaintenance_category tr").unbind("click");
						$("#buttonsMainCat").css("display", "none");
						$("#updatebuttonsMainCat").css("display", "block");
						$(".txtMainCat").removeAttr("readonly");
						$(".txtMainCat2").prop("disabled", false);
						$(".txtMainCat2").removeAttr("readonly");
						$(".radFixedPayment").prop("disabled", false);
						$(".radAddtask").prop("disabled", false);
						$(".IconDiv").css("display", "block");
					}else{
						$("#tblmaintenance_category tr").unbind("click");
						$("#buttonsMainCat").css("display", "none");
						$("#updatebuttonsMainCat").css("display", "block");
						$("#MainCatDesc").removeAttr("readonly");
						$(".txtMainCat2").prop("disabled", false);
						$(".txtMainCat2").removeAttr("readonly");
						$(".radFixedPayment").prop("disabled", false);
						$(".radAddtask").prop("disabled", false);
						$(".IconDiv").css("display", "block");
						if(arr[1] == "Yes"){
							$("#txtFixedPayment").css("display", "block");
							$("#txtFixedPayment").removeAttr("readonly");
						}else{
							$("#txtFixedPayment").attr("readonly", "readonly");
							$("#txtFixedPayment").css("display", "block");
						}
					}
				}
			})
		}
	}

	function updateMainCat(){
		var MainCatID = $("#HiddenMainCatID").val();
		var MainCatCode = $("#MainCatCode").val();
		var MainCatDesc = $("#MainCatDesc").val();
		var MainCatType = $("#MainCatType").val();
		var MainisReading = $("#MainCatisReading").val();
		var isFixed = "";
		var FixedAmount = 0;
		var AddTask = "";
		$(".radFixedPayment").each(function(){
			if($(this).is(":checked")){
				if($(this).attr("id") == "FixedPaymentYes"){
					isFixed = "Yes";
					FixedAmount = $("#txtFixedPayment").val().replace(/,/g,"");
				}else{
					isFixed = "No";
					FixedAmount = 0;
				}
			}
		})
		$(".radAddtask").each(function(){
			if($(this).is(":checked")){
				if($(this).attr("id") == "AddTaskYes"){
					AddTask = "Yes";
				}else{
					AddTask = "No";
				}
			}
		})
		var Count = 0;
		$(".txtMainCat").each(function(){
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
				url: 'setup/referentialFiles/main_cat/class.php',
				data: 'MainCatCode=' + MainCatCode + '&MainCatDesc=' + MainCatDesc + '&MainCatType=' + MainCatType + '&isFixed=' + isFixed + '&FixedAmount=' + FixedAmount + '&AddTask=' + AddTask + '&MainCatID=' + MainCatID + '&MainisReading=' + MainisReading + '&form=updateMainCat',
				success: function(data){
					var arr = data.split("|");
					if(arr[0] == 1){
						setTimeout(function(){
							showmodal("alert", "Maintenance Category successfully updated.", "cancelbuttonMainCat", null, "", null, "0");
						}, 500)
						hiddenpangupload54(arr[1]);
					}else {
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

	function clickDeleteMainCat() {
		var MainCatCode = $("#MainCatCode").val();
		var MainCatDesc = $("#MainCatDesc").val();
		$.ajax({
			type: 'POST',
			url: 'setup/referentialFiles/main_cat/class.php',
			data: 'MainCatCode=' + MainCatCode + '&form=clickUpdateMainCat',
			success:function(data){
				var arr = data.split("|");
				if(arr[0] == 0){
					if(MainCatCode == ""){
						setTimeout(function(){
							showmodal("alert", "Select category first", "", null, "", null, "1");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("confirm", "Are you sure you want to delete " + MainCatDesc, "clickDeleteMainCat2", null, "", null, "0");
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

	function clickDeleteMainCat2(){
		var MainCatCode = $("#MainCatCode").val();
		var MainCatDesc = $("#MainCatDesc").val();
		var MainCatID = $("#HiddenMainCatID").val();
		$.ajax ({
			type: 'POST',
			url: 'setup/referentialFiles/main_cat/class.php',
			data: 'MainCatCode=' + MainCatCode + '&MainCatID=' + MainCatID + '&form=deleteMainCat',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", MainCatDesc + " has been deleted.", "cancelbuttonMainCat", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function showpic(){
		var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById("txtCatIcon").files[0]);
		
		oFReader.onload = function (oFREvent) {
			$("#imahengmetro").css("display", "inline-block");
			$("#logongupload").css("display", "none");
			$("#textngupload").css("display", "none");
			$("#btnremovephoto").css("display", "block");
			document.getElementById("imahengmetro").src = oFREvent.target.result;
		};
	}

	function removephoto(){
		$("#imahengmetro").attr("src", "#");
		$("#imahengmetro").css("display", "none");
		$("#logongupload").css("display", "block");
		$("#textngupload").css("display", "block");
		$("#txtCatIcon").val("");
		$("#btnremovephoto").css("display", "none");
	}

	function hiddenpangupload54(id){
		$("#pinaghuhugutan").val(id);
		var data = new FormData($('#posting_reficon')[0]);
      	$.ajax({
	        type: 'POST',
	        url: 'setup/referentialFIles/main_cat/uploadingicon.php',
	        data: data,
	        mimeType: 'multipart/form-data',
	        contentType: false,
	        cache: false,
	        processData: false,
	        success:function(data2){
	        	removephoto();
	        }
      	})
	}

	function AutoConsolidateCategory(){
		var key = $('#txtsearchMainCat').val();
		$.ajax ({
		type: 'POST',
		url: 'setup/referentialFiles/main_cat/class.php',
		data: 'key=' + key + '&form=AutoConsolidateCategory',
		success: function (data) {
			if(data == 1){
				setTimeout(function(){
					showmodal("alert", "List of maintenance category successfully exported.", "", null, "", null, "0");
				}, 500)
			}else{
				setTimeout(function(){
					showmodal("alert", "Failed to export list of maintenance category.", "", null, "", null, "1");
				}, 500)
			}
		}
		})
	}
</script>