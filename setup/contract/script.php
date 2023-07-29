<script type="text/javascript">
	$(function(){
		CKEDITOR.replace('txtckEditor',{
                height  : '400px',
   		});
		$(".fixTable").tableHeadFixer();
		$("#txtLayoutPage").val("1");
		fncLayoutList();
		$("#txtLayoutKey").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtLayoutPage").val("1");
				fncLayoutList(); 
			}else if(x == '8'){
                if($('#txtLayoutKey').val() == ""){
					$("#txtLayoutPage").val("1");
                    fncLayoutList();
                }
            }
		});
	})

	function fncLayoutList(){
		var key = $("#txtLayoutKey").val();
		var page = $("#txtLayoutPage").val();
		$.ajax({
			type: 'POST',
			url: 'setup/contract/class.php',
			data: 'page=' + page + '&key=' + key + '&form=fncLayoutList',
			beforeSend : function() {
                $('#indexloadingscreen').addClass('myspinner');
            },
			success: function(data){
                $('#indexloadingscreen').removeClass('myspinner');
				if(data != ""){
                    $("#tbodyLayoutList").html(data);
                }else{
                    $("#tbodyLayoutList").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
                }
                fncCLayoutEntries();
				fncCLayoutPagination();
			}
		})
	}

	function fncCLayoutEntries(){
		var key = $("#txtLayoutKey").val();
		var page = $("#txtLayoutPage").val();
        $.ajax({
            type: 'POST',
			url: 'setup/contract/class.php',
            data: 'key=' + key + '&page=' + page + '&form=fncCLayoutEntries',
            success: function(data){
                $("#txtLayoutEntries").text(data);
            }
        })
	}

	function fncCLayoutPagination(){
		var key = $("#txtLayoutKey").val();
		var page = $("#txtLayoutPage").val();
        $.ajax({
            type: 'POST',
			url: 'setup/contract/class.php',
            data: 'key=' + key + '&page=' + page + '&form=fncCLayoutPagination',
            success: function(data){
                $("#ulLayoutPagination").html(data);
            }
        })
	}
	
	function ClickPaginationFunc(page, pagenums){
	    $(".pgnumCLayout").removeClass("active");
	    $("#pgCLayout" + pagenums).addClass("active");
	    $("#txtLayoutPage").val(page);
	    fncLayoutList();
	}

	function fncAddNewContractLayout(){
		$("#mdl_AddNewContractLayout").modal('show');
		$("#txtContractCode").val('');
		$("#txtContractDesc").val('');
		$("#txtLayoutID").val('');
		CKEDITOR.instances['txtckEditor'].setData('');
		$("#ulProposal").css("display", "block");
		$("#ulLeaseContract").css("display", "none");
	}

	function fncChangeDocument(){
		// var DocType = $("#txtContractType").val();
		// if(DocType == 'Proposal'){
		// 	$("#ulProposal").css("display", "block");
		// 	$("#ulLeaseContract").css("display", "none");
		// }else if(DocType == 'AwardNotice'){
		// 	$("#ulProposal").css("display", "none");
		// 	$("#ulLeaseContract").css("display", "block");
		// }else if(DocType == 'LeaseContract'){
		// 	$("#ulProposal").css("display", "none");
		// 	$("#ulLeaseContract").css("display", "block");
		// }else if(DocType == 'EventContract'){
		// 	$("#ulProposal").css("display", "none");
		// 	$("#ulLeaseContract").css("display", "block");
		// }else{
		// 	$("#ulProposal").css("display", "block");
		// 	$("#ulLeaseContract").css("display", "none");
		// }
	}

	function fncSaveLayout(){
		var LayoutID = $("#txtLayoutID").val();
		var ContractType = $("#txtContractType").val();
		var Code = $("#txtContractCode").val();
		var Desc = $("#txtContractDesc").val();
		var ckEditorData = CKEDITOR.instances['txtckEditor'].getData();
		if(Code != '' || Desc != '' || ckEditorData != ''){
			$.ajax({
				type: 'POST',
				url: 'setup/contract/class.php',
				data: 'ContractType=' + ContractType + '&Code=' + encodeURIComponent(Code) + '&Desc=' + encodeURIComponent(Desc) + '&ckEditorData=' + encodeURIComponent(ckEditorData) + '&LayoutID=' + LayoutID + '&form=fncSaveLayout',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							if(LayoutID == ''){
								showmodal("alert", "Contract layout successfully saved.", "fncClearLayout", null, "", null, "0");
							}else{
								showmodal("alert", "Contract layout successfully updated.", "fncClearLayout", null, "", null, "0");
							}
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", "Failed to save contract layout.", "", null, "", null, "1");
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

	function fncEditLayout(id){
		$("#mdl_AddNewContractLayout").modal('show');
		$.ajax({
			type: 'POST',
			url: 'setup/contract/class.php',
			data: 'id=' + id + '&form=fncEditLayout',
			success: function(data){
				var arr = JSON.parse(data);
				$("#txtContractCode").val(arr[0]);
				$("#txtContractDesc").val(arr[1]);
				CKEDITOR.instances['txtckEditor'].setData(arr[2]);
				$("#txtContractType").val(arr[3]);
				$("#txtLayoutID").val(id);
			}
		})
	}

	function fncDeleteLayout(id){
		setTimeout(function(){
        	showmodal("confirm", "Are you sure you want to delete this contract layout?", "fncDeleteLayout2", id+"|", "", null, "1");
		}, 500)
	}	

	function fncDeleteLayout2(id){
		$.ajax({
			type: 'POST',
			url: 'setup/contract/class.php',
			data: 'id=' + id + '&form=fncDeleteLayout',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Contract layout successfully deleted.", "fncLayoutList", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to delete contract layout.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function fncClearLayout(){
		$("#mdl_AddNewContractLayout").modal('hide');
		$("#txtContractCode").val('');
		$("#txtContractDesc").val('');
		CKEDITOR.instances['txtckEditor'].setData('');
		$("#txtLayoutID").val('');
		fncLayoutList();
	}
</script>