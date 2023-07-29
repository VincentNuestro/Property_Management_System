<div class="modal fade fade-scale" role="dialog" id="modalshortcutunit" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg" style="width: 90%;">
		<div class="modal-content">
			<div id="preloadshortcutunit"></div>
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#modalshortcutunit').modal('hide');">×</button>
				<h4 class="modal-title" style="font-size: 18px;" id="hdrListOfUnits">List of Available Units</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="widget-box widget-color-blue3" id="widget-box-7">
							<div class="widget-header">
								<h5 class="widget-title">Select Unit</h5>
							</div>
							<div class="widget-body" style="height: 70vh;">
								<div class="widget-main">
									<div class="row form-group">
										<div class="col-md-4 col-xs-4">
											<span class="input-icon" style="width: 100%;">
						                        <input type="text" class="form-control" placeholder="Search Unit" id="searchshortcutunit">
						                        <i class="ace-icon fa fa-search nav-search-icon"></i>
						                    </span>
										</div>
										<div class="col-md-4 col-xs-4">
											<select id="txtShortcutUnitType" class="form-control" onchange="$('#shortcutuserpage').val('1'); LeadsInqShrtctUnit();">
												<option value="">-- Select Unit Type --</option>
												<option value="SET">SET</option>
												<option value="LCA">LCA</option>
											</select>
										</div>
										<div class="col-md-4 col-xs-4 <?php session_start(); if($_SESSION['MMS-Designation'] == "Superuser" || $_SESSION['MMS-Designation'] == "GatessoftCorp"){ }else{ ?> hide <?php } ?>">
											<select id="txtShortucutUnit" class="form-control" onchange="$('#shortcutuserpage').val('1'); LeadsInqShrtctUnit();"></select>
										</div>
									</div>
							        <div class="row form-group" style="margin-top: -10px;">
							        	<div class="col-md-12">
											<div style="height: 55vh;">
												<table class="table table-bordered fixTable">
													<thead>
														<th style="width: 15%">Classification</th>
														<!-- <th style="width: 15%">Unit ID</th> -->
														<th style="width: 20%">Unit Name</th>
														<th style="width: 15%">Unit Type</th>
					  									<!-- <th style='width: 20%;' class="txtSysBuilding"></th> -->
														<th style="width: 15%;z-index: 1;">Options</th>
													</thead>
													<tbody id="tblselectshortcutunit"></tbody>
												</table>
											</div>
											<table class="tabledash_footer table" style="margin: 0px !important;">
								              	<thead>
									                <tr>
									                  	<th style="width: 100%;padding-top: 10px;padding-bottom: 10px;">
										                    <font id="shortcutentries" style="float: left;margin-left: 15px;font-weight: normal;font-weight: 8px !important;"></font>
										                    <input id="shortcutuserpage" type="hidden">
										                    <ul id="ulshortcutpagination" class="pagination pull-right"></ul>
									                  	</th>
									                </tr>
								              	</thead>
								            </table>
								        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="widget-box widget-color-blue3" id="widget-box-7">
							<div class="widget-header">
								<h5 class="widget-title">Selected Unit</h5>
								<input type="hidden" id="txtShrtSubUnit">
								<div class="widget-toolbar">
									<button class="btn btn-warning btn-xs btn-round" onclick="fncCheckAllSelectedUnits();">Select All</button>
									<button class="btn btn-warning btn-xs btn-round" onclick="fncUncheckAllSelectedUnits();">Unselect All</button>
									<button class="btn btn-danger btn-xs btn-round" onclick="fncRemoveChecked();">Remove</button>
								</div>
							</div>
							<div class="widget-body" style="height: 70vh;">
								<div class="widget-main">
									<div class="row">
										<div class="col-md-12" style="height: 63vh;overflow-y: scroll;">
											<div id="divSelectedUnits"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-round" onclick="fncAddSelectedUnits('', '2');"><span class="fa fa-check"></span> Save</button>
            </div>
		</div>
	</div>
</div>

<div class="modal fade fade-scale" role="dialog" id="mdl_UnitInfo" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#mdl_UnitInfo').modal('hide');">×</button>
				<h4 class="modal-title" style="font-size: 18px;">Select Unit</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-md-12">
						<div id="divUnitListContainer"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$("#searchshortcutunit").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				$("#shortcutuserpage").val("1");
				LeadsInqShrtctUnit(); 
			}else if ( x == '8' ){
				if($('#searchshortcutunit').val() == ""){
					$("#shortcutuserpage").val("1");
					LeadsInqShrtctUnit();
				}
			}
		});
	})

	function fncSelectUnit(){
		loadmalllist();
		$("#divSelectedUnits").html("");
		$(".txtASU").each(function(){
			fncAddSelectedUnit($(this).val(), 'isSUMain');
		})
		$('#shortcutuserpage').val('1'); 
		$('#modalshortcutunit').modal('show');
		LeadsInqShrtctUnit();
		var StoreName = $("#txtTradeName").val();
		if(StoreName == ""){
			$("#hdrListOfUnits").text("List of Units");
		}else{
			$("#hdrListOfUnits").text("List of Units - " + StoreName);
		}
	}

	function loadmalllist(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success: function(data){
				$("#txtShortucutUnit").html(data);
			}, complete: function(){
				LeadsInqShrtctUnit();
			}
		})
	}

	function fncAddSelectedUnit(UnitID, isSUMain){
		$.ajax({
			type: 'POST',
			url: 'include/class.php',
			data: 'UnitID=' + UnitID + '&isSUMain=' + isSUMain + '&form=fncAddSelectedUnit',
			success: function(data){
				$("#divSelectedUnits").append(data)
			}, complete: function(){
				$("#mdl_UnitInfo").modal("hide");
				var colorbox_params = {
		          	rel: 'cbSelected-' + UnitID,
				   	reposition: true,
				  	scalePhotos: true,
				    scrolling: false,
					title: false,
			     	previous: '<i class="ace-icon fa fa-arrow-left"></i>',
		         	next: '<i class="ace-icon fa fa-arrow-right"></i>',
			        close: '&times;',
			      	current: '{current} of {total}',
			     	maxWidth: '100%',
				    maxHeight: '100%',
				   	onComplete: function(){
				     	$.colorbox.resize();
				   	}
				}
				$('[data-rel="cbSelected-'+ UnitID +'"]').colorbox(colorbox_params);
				$('#cboxLoadingGraphic').append("<i class='ace-icon fa fa-spinner orange'></i>");
				LeadsInqShrtctUnit();
				var isUrl = "<?php echo $_GET['url']; ?>";
				if(isUrl == "tenants"){
					fncgetPaymentSchedule();
				}
			}
		})
		$.ajax({ // Remove Sub Unit of Selected Main Unit
			type: 'POST',
			url: 'include/class.php',
			data: 'UnitID=' + UnitID + '&form=fncRemoveSUinList',
			success: function(data){
				if(data != ''){
					var arr = data.split("|");
					for(var i=0; i<=arr.length-1; i++){
						$("#SU_"+arr[i]).remove();
					}
				}
			}
		})
	}

	function LeadsInqShrtctUnit(){
		var page = $("#shortcutuserpage").val();
		var MallID = $("#txtShortucutUnit").val();
		var UnitType = $("#txtShortcutUnitType").val();
		var key = $("#searchshortcutunit").val();
		var UnitMainIDs = "";
		$(".isSUMain").each(function(){
			UnitMainIDs += $(this).val() + "|";
		})
		$(".txtASU").each(function(){
			// UnitMainIDs += $(this).val() + "|";
		})
		$.ajax({
			type: 'POST',
			url: 'include/class.php',
			data: 'UnitType=' + UnitType + '&MallID=' + MallID + '&page=' + page + '&key=' + key + '&UnitMainIDs=' + UnitMainIDs + '&form=LeadsInqShrtctUnit',
			beforeSend : function() {
				$('#preloadshortcutunit').addClass('myspinner');
			},
			success: function(data){
				$('#preloadshortcutunit').removeClass('myspinner');
				if(data != "") {
					$("#tblselectshortcutunit").html(data);
				}else{
					$("#tblselectshortcutunit").html("<tr><td colspan='6' style='text-align: center;'>No Data Found...</td></tr>");
				}
			}, complete: function(){
				LeadsInqShrtctUnitPagination();
				LeadsInqShrtctUnitEntries();
				$(".chkUnitsAll").prop("checked", false);
			}
		})
	}

	function LeadsInqShrtctUnitEntries(){
		var page = $("#shortcutuserpage").val();
		var MallID = $("#txtShortucutUnit").val();
		var UnitType = $("#txtShortcutUnitType").val();
		var key = $("#searchshortcutunit").val();
		var UnitMainIDs = "";
		$(".isSUMain").each(function(){
			UnitMainIDs += $(this).val() + "|";
		})
		$.ajax({
		  	type: 'POST',
		  	url: 'include/class.php',
		  	data: 'UnitType=' + UnitType + '&MallID=' + MallID + '&page=' + page + '&key=' + key + '&UnitMainIDs=' + UnitMainIDs + '&form=LeadsInqShrtctUnitEntries',
		  	success: function(data){
		  		$("#shortcutentries").text(data);
		  	}
		});
  	}

  	function LeadsInqShrtctUnitPagination(){
		var page = $("#shortcutuserpage").val();
		var MallID = $("#txtShortucutUnit").val();
		var UnitType = $("#txtShortcutUnitType").val();
		var key = $("#searchshortcutunit").val();
		var UnitMainIDs = "";
		$(".isSUMain").each(function(){
			UnitMainIDs += $(this).val() + "|";
		})
		$.ajax({
	  		type: 'POST',
	  		url: 'include/class.php',
	  		data: 'UnitType=' + UnitType + '&MallID=' + MallID + '&page=' + page + '&key=' + key + '&UnitMainIDs=' + UnitMainIDs + '&form=LeadsInqShrtctUnitPagination',
	  		success: function(data){
				$("#ulshortcutpagination").html(data);
	  		}
		});
  	}

  	function btnLeadsInqShrtctUnit(page, pagenums){
		$(".pgnumLeadsInqShrtctUnit").removeClass("active");
		$("#pgLeadsInqShrtctUnit" + pagenums).addClass("active");
		$("#shortcutuserpage").val(page);
		LeadsInqShrtctUnit();
  	}

  	function ViewUnitInformation(UnitID){
    	var UnitSubIDs = "";
		$(".isSUSub").each(function(){
			UnitSubIDs += $(this).val() + "|";
		})
    	$("#mdl_UnitInfo").modal("show");
    	$.ajax({
    		type: 'POST',
	  		url: 'include/class.php',
	  		data: 'UnitID=' + UnitID + '&UnitSubIDs=' + UnitSubIDs + '&form=ViewUnitInformation',
	  		success: function(data){
	  			$("#divUnitListContainer").html(data);
	  		}, complete: function(){
	  			var colorbox_params = {
		          	rel: 'colorbox',
				   	reposition: true,
				  	scalePhotos: true,
				    scrolling: false,
					title: false,
			     	previous: '<i class="ace-icon fa fa-arrow-left"></i>',
		         	next: '<i class="ace-icon fa fa-arrow-right"></i>',
			        close: '&times;',
			      	current: '{current} of {total}',
			     	maxWidth: '100%',
				    maxHeight: '100%',
				   	onComplete: function(){
				     	$.colorbox.resize();
				   	}
				}
				$('[data-rel="colorbox"]').colorbox(colorbox_params);
				$('#cboxLoadingGraphic').append("<i class='ace-icon fa fa-spinner orange'></i>");
	  		}
    	})
    }

    function fncChangeSelectID(UnitID){
    	$("#btnChangeSelectID").attr("onclick", "fncAddSelectedUnit(\""+ UnitID +"\", \"isSUSub\")");
    	$.ajax({
    		type: 'POST',
    		url: 'mainclass.php',
    		data: 'UnitID=' + UnitID + '&form=fncChangeSelectID',
    		success: function(data){
    			$("#divColorBox-"+UnitID).html(data);
    		}, complete: function(){
	  			var colorbox_params = {
		          	rel: 'colorbox-' + UnitID,
				   	reposition: true,
				  	scalePhotos: true,
				    scrolling: false,
					title: false,
			     	previous: '<i class="ace-icon fa fa-arrow-left"></i>',
		         	next: '<i class="ace-icon fa fa-arrow-right"></i>',
			        close: '&times;',
			      	current: '{current} of {total}',
			     	maxWidth: '100%',
				    maxHeight: '100%',
				   	onComplete: function(){
				     	$.colorbox.resize();
				   	}
				}
				$('[data-rel="colorbox-'+ UnitID +'"]').colorbox(colorbox_params);
				$('#cboxLoadingGraphic').append("<i class='ace-icon fa fa-spinner orange'></i>");
	  		}
    	})
    }

    

	function fncCheckAllSelectedUnits(){
		$(".chkSelectedUnits").prop("checked", true);
	}

	function fncUncheckAllSelectedUnits(){
		$(".chkSelectedUnits").prop("checked", false);
	}

	function fncRemoveChecked(){
		$(".chkSelectedUnits").each(function(){
			if($(this).is(":checked")){
				$("#SU_"+$(this).val()).remove();
			}
		})
		LeadsInqShrtctUnit();
	}

	function fncAddSelectedUnits(InquiryID, fncType){
		var UnitIDs = "";
		var UnitCount = 0;
		$(".chkSelectedUnits").each(function(){
			UnitIDs += $(this).val() + "|";
			UnitCount++;
		})
		$.ajax({
			type: 'POST',
			url: 'include/class.php',
			data: 'UnitIDs=' + UnitIDs + '&form=checkSelectedUnits',
			success: function(data){
				var arr = data.split("|");
				if(arr[0] == 1){
					$("#txtMallID").val(arr[1]);
					$.ajax({
						type: 'POST',
						url: 'include/class.php',
						data: 'UnitIDs=' + UnitIDs + '&fncType=' + fncType + '&UnitCount=' + UnitCount + '&form=fncAddSelectedUnits',
						success: function(data){
							var arr = data.split("|");
							$("#divUnitInformation").html(arr[0]);
							$("#txtNDTMonthlyRent").val(arr[1]);
							$("#txtNDTMonthlyRentOrig").val(arr[1]);
							$("#txtGlobalSecDepAmount").val(arr[1]);
							$("#txtGlobalConBondAmount").val(arr[1]);
			                $("#txtGlobalArea").val(arr[2]);
							$("#txtGlobalRate").val(arr[3]);
						}, complete: function(){
							var arr = UnitIDs.split("|");
							for(var i=0; i<=arr.length-1; i++){
								var colorbox_params = {
						          	rel: 'cbUnitList-' + arr[i],
								   	reposition: true,
								  	scalePhotos: true,
								    scrolling: false,
									title: false,
							     	previous: '<i class="ace-icon fa fa-arrow-left"></i>',
						         	next: '<i class="ace-icon fa fa-arrow-right"></i>',
							        close: '&times;',
							      	current: '{current} of {total}',
							     	maxWidth: '100%',
								    maxHeight: '100%',
								   	onComplete: function(){
								     	$.colorbox.resize();
								   	}
								}
								$('[data-rel="cbUnitList-'+ arr[i] +'"]').colorbox(colorbox_params);
								$('#cboxLoadingGraphic').append("<i class='ace-icon fa fa-spinner orange'></i>");
								// if($("#wdTabInfo i").hasClass("fa fa-chevron-down")){
								// 	$("#wdTabInfo").click();
								// }
							}
							$('#modalshortcutunit').modal('hide');
							fncgetPaymentSchedule();
							fncSaveFixedRent();
						}
					})
				}else if(arr[0] == 2){	
					setTimeout(function(){
						showmodal("alert", arr[1], "", null, "", null, "1");
					}, 500)
				}else{
					$("#divUnitInformation").html("");
					$('#modalshortcutunit').modal('hide'); 
        			$("#divUnitInformation").html("<div class='alert alert-info'><h3 class='center'> No Unit Selected... </h3></div>");
					// setTimeout(function(){
					// 	showmodal("alert", arr[1], "", null, "", null, "1");
					// }, 500)
				}
			}
		})
	}
</script>