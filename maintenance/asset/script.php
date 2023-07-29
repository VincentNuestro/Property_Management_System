<script type="text/javascript">
	$(function(){
	    $(".fixTable").tableHeadFixer(); 
		$("#txtAssetPage").val("1");
		fncShowAssetList();
		$(".AmountConvertion").change(function(){
       		var x = ($(this).val()).replace(/,/g,"");
            var v = parseFloat(x||0);
            $(this).val(v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });
		$(".NumberOnly").keydown(function (e){ 
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || 
				(e.keyCode == 65 && e.ctrlKey === true) ||  
				(e.keyCode >= 35 && e.keyCode <= 40)) { 
				return;
			} 
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		$("#txtSearchAsset").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#txtAssetPage").val("1");
				fncShowAssetList(); 
			}else if(x == '8'){
                if($('#txtSearchAsset').val() == ""){
					$("#txtAssetPage").val("1");
                    fncShowAssetList();
                }
            }
		});
		$("#txtSearchMaintenance").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				fncAssetMaintenance(); 
			}else if(x == '8'){
                if($('#txtSearchMaintenance').val() == ""){
                    fncAssetMaintenance();
                }
            }
		});
	})

	function fncShowAssetList(){
	    var page = $("#txtAssetPage").val();
	    var key = $("#txtSearchAsset").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/asset/class.php',
			data: 'key=' + key + '&page=' + page + '&form=fncShowAssetList',
			beforeSend: function(){
		       	$('#indexloadingscreen').addClass('myspinner');
		    },
		    success: function(data){
        		$('#indexloadingscreen').removeClass('myspinner');
        		if(data != ""){
		          	$("#tblAssetList").html(data);
		        }else{
		          	$("#tblAssetList").html("<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>");
		        }
				fncAssetListEntries();
				fncAssetListPage();
			}
		})
	}

	function fncAssetListEntries(){
	    var page = $("#txtAssetPage").val();
	    var key = $("#txtSearchAsset").val();
	    $.ajax({
	        type: 'POST',
	        url: 'maintenance/asset/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncAssetListEntries',
	        success: function(data){
	            $("#txtAssetEntries").text(data);
	        }
	    });
	}

	function fncAssetListPage(){
	    var page = $("#txtAssetPage").val();
	    var key = $("#txtSearchAsset").val();
	    $.ajax({
	        type: 'POST',
	        url: 'maintenance/asset/class.php',
	        data: 'key=' + key + '&page=' + page + '&form=fncAssetListPage',
	        success: function(data){
	            $("#txtAssetPagination").html(data);
	        }
	    });
	}

    function fncAssetListPageFunc(CurrentPage, PageNumAssetList){
        $(".pgNumAssetList").removeClass("active");
        $("#pgAssetList" + PageNumAssetList).addClass("active");
        $("#txtAssetPage").val(CurrentPage);
        fncShowAssetList();
    }
	
	function fncNewAsset(){
		$("#mdlNewAsset").modal("show");
		$("#txtAssetControlNo").removeAttr("readonly");
		removeuserphoto();
		$(".txtAssetRequired").val("");
		$("#hdrNewAsset").text("New Asset");
		fncShowslctComponents();
	}

	function showimgggggg(){
		var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById("txtAssetFile").files[0]);
		oFReader.onload = function (oFREvent) {
			$("#txtAssetImage").css("display", "block");
			$("#txtAssetSpan").css("display", "none");
			$("#txtAssetClick").css("display", "none");
			document.getElementById("txtAssetImage").src = oFREvent.target.result;
			$("#btnRemoveAssetAvatar").css("display", "inline-block");
		};
	}
	
	function removeuserphoto(){
        $("#btnRemoveAssetAvatar").css("display", "none");
		$("#txtAssetImage").attr("src", "#");
		$("#txtAssetImage").css("display", "none");
		$("#txtAssetSpan").css("display", "block");
		$("#txtAssetClick").css("display", "block");
		$("#txtAssetFile").val("");
	}

	function fncSaveAsset(){
		var count = 0;
		$(".txtAssetRequired").each(function(){
			if($(this).val() == ""){
				count++;
			}
		})
		var isEdit = $("#hdrNewAsset").text();
		// if(count == 0){
			var ControlNo = $("#txtAssetControlNo").val();
			var AssetName = $("#txtAssetName").val();
			var Category = $("#txtAssetCategory").val();
			var Class = $("#txtAssetClass").val();
			var Brand = $("#txtAssetBrand").val();
			var Color = $("#txtAssetColor").val();
			var Serial = $("#txtAssetSerial").val();
			var Barcode = $("#txtAssetBarcode").val();
			var Supplier = $("#txtAssetSupplier").val();
			var AssetDimension = $("#txtAssetDimension").val();
			var Status = $("#txtAssetStatus").val();
			var Department = $("#txtAssetDepartment").val();
			var AssetHolder = $("#txtAssetHolder").val();
			var Location = $("#txtAssetLocation").val();
			var AssetQuantity = $("#txtAssetQuantity").val();
			var AssetUnit = $("#txtAssetUnit").val();
			var AcquisitionAmount = $("#txtAssetAcquisitionAmount").val().replace(/,/g, "");;
			var LifeinYears = $("#txtAssetLifeInYears").val();
			var DepreciatedCost = $("#txtAssetDepreciatedCost").val().replace(/,/g, "");;
			var SalvageAmount = $("#txtAssetSalvageAmount").val().replace(/,/g, "");;
			var ParentUnit = $("#txtAssetParentUnit").val();
			var Ownership = $("#txtAssetOwnership").val();
			var AcquisitionDate = $("#txtAssetAcquisitionDate").val();
			$.ajax({
				type: 'POST',
				url: 'maintenance/asset/class.php',
				data: 'ControlNo=' + ControlNo + '&AssetName=' + AssetName + '&Category=' + Category + '&Class=' + Class + '&Brand=' + Brand + '&Color=' + Color + '&Serial=' + Serial + '&Barcode=' + Barcode + '&Supplier=' + Supplier + '&AssetDimension=' + AssetDimension + '&Status=' + Status + '&Department=' + Department + '&AssetHolder=' + AssetHolder + '&Location=' + Location + '&AssetQuantity=' + AssetQuantity + '&AssetUnit=' + AssetUnit + '&AcquisitionAmount=' + AcquisitionAmount + '&LifeinYears=' + LifeinYears + '&DepreciatedCost=' + DepreciatedCost + '&SalvageAmount=' + SalvageAmount + '&ParentUnit=' + ParentUnit + '&Ownership=' + Ownership + '&AcquisitionDate=' + AcquisitionDate + '&isEdit=' + isEdit + '&form=fncSaveAsset',
				success: function(data){
					var arr = data.split("|");
					if(arr[0] == 1){
						setTimeout(function(){
							showmodal("alert", arr[1], "fncUploadAssetImage", null, "", null, "0");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", arr[1], "", null, "", null, "1");
						}, 500)
					}
				}
			})
		// }else{
		// 	setTimeout(function(){
		// 		showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
		// 	}, 500)
		// }
	}

	function fncUploadAssetImage(){
		var data = new FormData($('#frmAssetImage')[0]);
		$.ajax({
	        type: 'POST',
	        url: 'maintenance/asset/saveassetimage.php',
	        data: data,
	        mimeType: 'multipart/form-data',
	        contentType: false,
	        cache: false,
	        processData: false,
	        success: function(data2){
				$("#mdlNewAsset").modal("hide");
				fncShowAssetList();
	        }
      	})
	}

	function editAssetInfo(AssetNo){
		$("#mdlNewAsset").modal("show");
		$.ajax({
			type: 'POST',
			url: 'maintenance/asset/class.php',
			data: 'AssetNo=' + AssetNo + '&form=fncShowslctComponents',
			success: function(data){
				$("#txtAssetParentUnit").html(data);
			},
			complete: function(){
				$.ajax({
					type: 'POST',
					url: 'maintenance/asset/class.php',
					data: 'AssetNo=' + AssetNo + '&form=fncAssetInfo',
					success: function(data){
						var arr = data.split("|");
						$("#txtAssetControlNo").val(AssetNo);
						$("#txtAssetControlNo").attr("readonly", "readonly");
						$("#txtAssetName").val(arr[1]);
						$("#txtAssetAcquisitionDate").val(arr[2]);
						$("#txtAssetAcquisitionAmount").val(arr[3]);
						$("#txtAssetStatus").val(arr[4]);
						$("#txtAssetCategory").val(arr[5]);
						$("#txtAssetColor").val(arr[6]);
						$("#txtAssetSupplier").val(arr[7]);
						$("#txtAssetDepartment").val(arr[8]);
						$("#txtAssetLocation").val(arr[9]);
						$("#txtAssetLifeInYears").val(arr[10]);
						$("#txtAssetClass").val(arr[11]);
						$("#txtAssetSerial").val(arr[12]);
						$("#txtAssetDimension").val(arr[13]);
						$("#txtAssetOwnership").val(arr[14]);
						$("#txtAssetQuantity").val(arr[15]);
						$("#txtAssetDepreciatedCost").val(arr[16]);
						$("#txtAssetBrand").val(arr[17]);
						$("#txtAssetBarcode").val(arr[18]);
						$("#txtAssetParentUnit").val(arr[19]);
						$("#txtAssetHolder").val(arr[20]);
						$("#txtAssetUnit").val(arr[21]);
						$("#txtAssetSalvageAmount").val(arr[22]);
						if(arr[23] == "1"){
							removeuserphoto();
						}else{
							$("#txtAssetImage").attr("src", arr[0]);
							$("#txtAssetImage").attr("alt", arr[1]);
							$("#txtAssetImage").css("display", "block");
							$("#txtAssetSpan").css("display", "none");
							$("#txtAssetClick").css("display", "none");
							$("#btnRemoveAssetAvatar").css("display", "inline-block");
						}
						$("#hdrNewAsset").text("Edit Asset");
					}
				})
			}
		})
	}

	function openmdlAssetInfo(AssetNo){
		$("#mdlAssetInfo").modal("show");
		$("#txtAssetInfoControlNo").text(AssetNo);
		fncAssetInfo();
		$(".thistab:first-child").children('a').click();
	}

	function fncAssetInfo(){
		var AssetNo = $("#txtAssetInfoControlNo").text();
		$.ajax({
			type: 'POST',
			url: 'maintenance/asset/class.php',
			data: 'AssetNo=' + AssetNo + '&form=fncAssetInfo',
			success: function(data){
				var arr = data.split("|");
				$("#imgAssetImage").attr("src", arr[0]);
				$("#imgAssetImage").attr("alt", arr[1]);
				$("#txtAssetInfoAssetName").text(arr[1]);
				$("#txtAssetInfoAcquisitionDate").text(arr[2]);
				$("#txtAssetInfoAcquisitionAmount").text(arr[3]);
				$("#txtAssetInfoStatus").text(arr[4]);
				$("#txtAssetInfoCategory").text(arr[5]);
				$("#txtAssetInfoColor").text(arr[6]);
				$("#txtAssetInfoSupplier").text(arr[7]);
				$("#txtAssetInfoDepartment").text(arr[8]);
				$("#txtAssetInfoLocation").text(arr[9]);
				$("#txtAssetInfoLifeinYears").text(arr[10]);
				$("#txtAssetInfoItemClass").text(arr[11]);
				$("#txtAssetInfoSerialNo").text(arr[12]);
				$("#txtAssetInfoDimension").text(arr[13]);
				$("#txtAssetInfoOwnership").text(arr[14]);
				$("#txtAssetInfoQuantity").text(arr[15]);
				$("#txtAssetInfoDepreciatedCost").text(arr[16]);
				$("#txtAssetInfoBrand").text(arr[17]);
				$("#txtAssetInfoBarcodeNo").text(arr[18]);
				$("#txtAssetInfoParentUnit").text(arr[19]);
				$("#txtAssetInfoAssetHolder").text(arr[20]);
				$("#txtAssetInfoUnit").text(arr[21]);
				$("#txtAssetInfoSalvageAmount").text(arr[22]);
			}
		})
	}

	function fncAssetComponents(){
		var AssetNo = $("#txtAssetInfoControlNo").text();
		$.ajax({
			type: 'POST',
			url: 'maintenance/asset/class.php',
			data: 'AssetNo=' + AssetNo + '&form=fncAssetComponents',
			success: function(data){
				$("#tblAssetComponentList").html(data);
			}
		})
	}

	function fncShowslctComponents(){
		var AssetNo = $("#txtAssetControlNo").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/asset/class.php',
			data: 'AssetNo=' + AssetNo + '&form=fncShowslctComponents',
			success: function(data){
				$("#txtAssetParentUnit").html(data);
			}
		})
	}

	function fncChangeAssetHeader(header){
		$("#mdlAssetHeader").text(header);
	}

	function fncNewAssetMaintenance(JONumber, type){
		$("#mdlNewAssetMaintenance").modal("show");
		if(type == "New"){
			$("#hdrAssetMaintenance").text("New Asset Maintenance");
			$(".txtAssetRequiredExpense").val("");
			$("#txtAssetMainJONo").removeAttr("readonly");
			$(".txtAssetMaintenance").removeAttr("readonly");
			$(".btnAssetMaintenance").prop("disabled", false);
			$("#tblAssetMainPreExpenseList").html("");
		}else{
			if(type == "Edit"){
				$(".btnAssetMaintenance").prop("disabled", false);
				$(".txtAssetMaintenance").removeAttr("readonly");
				$("#hdrAssetMaintenance").text("Edit Asset Maintenance");
			}else{
				$(".btnAssetMaintenance").prop("disabled", true);
				$(".txtAssetMaintenance").attr("readonly", "readonly");
				$("#hdrAssetMaintenance").text("View Asset Maintenance");
			}
			$("#txtAssetMainJONo").attr("readonly", "readonly");
			$.ajax({
				type: 'POST',
				url: 'maintenance/asset/class.php',
				data: 'JONumber=' + JONumber + '&form=fncEditAssetMaintenance',
				success: function(data){
					var arr = data.split("|");
					$("#txtAssetMainJONo").val(arr[0]);
					$("#txtAssetMainJODate").val(arr[1]);
					$("#txtAssetMainJobOrderStatus").val(arr[2]);
					$("#txtAssetMainItemCondition").val(arr[3]);
					$("#txtAssetMainAssignedPerson").val(arr[4]);
					$("#tblAssetMainPreExpenseList").html(arr[5]);
				}
			})
		}
	}

	function fncAddExpense(){
		$("#mdlAddExpense").modal("show");
		$(".txtExpenseRequire").val("");
	}

	function fncAddSelectedExpense(){
		var count = 0;
		$(".txtExpenseRequire").each(function(){
			if($(this).val() == ""){
				count++;
			}
		})
		if(count == 0){
			$("#mdlAddExpense").modal("hide");
			var trCount = $("#HidExpenseCount").val();
			var CurrTRCount = Number(trCount) + 1;
			var ExpDate = $("#txtExpenseDate").val();
			var ExpType = $("#txtExpenseType").val();
			var ExpQuantity = $("#txtExpenseQuantity").val();
			var ExpAmount = $("#txtExpenseAmount").val();
			var ExpOR = $("#txtExpenseOR").val();
			var ExpRemarks = $("#txtExpenseRemarks").val();
			$("#tblAssetMainPreExpenseList").append("<tr id='trExpense"+ CurrTRCount +"'>" +
														"<td>"+ ExpDate +"</td>" +
														"<td>"+ ExpType +"</td>" +
														"<td>"+ ExpQuantity +"</td>" +
														"<td>"+ ExpAmount +"</td>" +
														"<td>"+ ExpOR +"</td>" +
														"<td>"+ ExpRemarks +"</td>" +
														"<td style='text-align: center;'><button class='btn btn-xs btn-danger btn-round' onclick='$(\"#trExpense"+ CurrTRCount +"\").remove();'><i class='fa fa-trash-o'></i></button></td>" +
													"</tr>");
			$("#HidExpenseCount").val(CurrTRCount);
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncSaveAllExpense(){
		var isEdit = $("#hdrAssetMaintenance").text();
		var AssetNo = $("#txtAssetInfoControlNo").text();
		var JONumber = $("#txtAssetMainJONo").val();
		var JODate = $("#txtAssetMainJODate").val();
		var JOStatus = $("#txtAssetMainJobOrderStatus").val();
		var ItemCondition = $("#txtAssetMainItemCondition").val();
		var AssignedPerson = $("#txtAssetMainAssignedPerson").val();
		var ExpenseList = "";
		$("#tblAssetMainPreExpenseList tr").each(function(){
			ExpenseList += $(this).find("td").eq(0).text() + "|" + $(this).find("td").eq(1).text() + "|" + $(this).find("td").eq(2).text() + "|" + $(this).find("td").eq(3).text().replace(/,/g, "") + "|" + $(this).find("td").eq(4).text() + "|" + $(this).find("td").eq(5).text() + "#";
		})
		var count = 0;
		$(".txtAssetRequiredExpense").each(function(){
			if($(this).val() == ""){
				count++;
			}
		})
		if(count == 0){
			if(ExpenseList != ""){
				$.ajax({
					type: 'POST',
					url: 'maintenance/asset/class.php',
					data: 'JONumber=' + JONumber + '&JODate=' + JODate + '&ExpenseList=' + ExpenseList + '&JOStatus=' + JOStatus + '&ItemCondition=' + ItemCondition + '&AssignedPerson=' + AssignedPerson + '&AssetNo=' + AssetNo + '&isEdit=' + isEdit + '&form=fncSaveAllExpense',
					success: function(data){
						var arr = data.split("|");
						if(arr[0] == 1){
							setTimeout(function(){
								showmodal("alert", arr[1], "fncAssetMaintenance", null, "", null, "0");
							}, 500)
						}else{
							setTimeout(function(){
								showmodal("alert", arr[1], "", null, "", null, "1");
							}, 500)
						}
					}
				})
			}else{
				setTimeout(function(){
					showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
				}, 500)
			}
		}else{
			setTimeout(function(){
				showmodal("alert", "Please fill all fields.", "", null, "", null, "1");
			}, 500)
		}
	}

	function fncAssetMaintenance(){
		var AssetNo = $("#txtAssetInfoControlNo").text();
		var key = $("#txtSearchMaintenance").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/asset/class.php',
			data: 'key=' + key + '&AssetNo=' + AssetNo + '&form=fncAssetMaintenance',
			success: function(data){
				$("#tblAssetMaintenanceList").html(data);
			},
			complete: function(){
				$("#mdlNewAssetMaintenance").modal("hide");
			}
		})
	}
</script>