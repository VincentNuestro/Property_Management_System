<script type="text/javascript">
	$(function(){
    	$(".fixTable").tableHeadFixer(); 
    	$(".unitlist").niceScroll({ cursorcolor: "#666", cursorwidth: "8px" });
		var _URL = window.URL || window.webkitURL;
		$("#txtimgfile").change(function (e) {
			var file, img;
			if ((file = this.files[0])){
				img = new Image();
				img.onload = function(){
					$("#imgwidth").val(this.width)
					$("#imgheight").val(this.height);
				};
				img.src = _URL.createObjectURL(file);
			}
		});
		$("#uploadimage").on('submit',(function(e) {
			e.preventDefault();
			$.ajax({
				url: 'floorplan/uploadfile.php',
				type: 'POST',
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					var arr = data.split("|");
					if(arr[1] == "1"){
						setTimeout(function(){
							showmodal("alert", "Photo has been uploaded.", "removephoto", null, "", null, "0");
						}, 1000)
						$("#txtmall2").val("");
						$("#txtwing2").val("");
						$("#txtfloor2").val("");
						$("#addfloorplan").modal("hide");
						loadfloorplan();
					}else{ 
						setTimeout(function(){
	                        showmodal("alert", arr[1], "", null, "", null, "1");
	                    }, 500) 
					}
				}
			}).error(function() {
				alert(data);
			});
		}));
		$(".date-picker").datepicker({
	        autoHide: true,
	        format: 'mm/dd/yyyy',
	        todayHighlight: true
	    });
		$(window).keydown(function(event){
			var x = event.keyCode;
			if(x == 27){ 
				addselect(); 
			}
		});
		$("#txtsearchofunithistory").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				unitstat(); 
			}else if(x == '8'){
                if($('#txtsearchofunithistory').val() == ""){
                    unitstat();
                }
            }
		});
		$("#txtsearchoftenanthistory").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				tenantstat(); 
			}else if(x == '8'){
                if($('#txtsearchoftenanthistory').val() == ""){
                    tenantstat();
                }
            }
		});
		$("#txtsearchinquiryhistory").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				showFPInquiryHistory(); 
			}else if(x == '8'){
                if($('#txtsearchinquiryhistory').val() == ""){
                    showFPInquiryHistory();
                }
            }
		});
		$("#txtsearchsoa").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				showSOAList(); 
			}else if(x == '8'){
                if($('#txtsearchsoa').val() == ""){
                    showSOAList();
                }
            }
		});
		$.ajax({
    		type: 'POST',
    		url: 'floorplan/mcp_mainclass.php',
    		data: 'floorid=<?php echo $_POST["floorid"]; ?>&form=FPMallNameHere',
    		success:function(data){
    			$("#FPMallNameHere").text(data);
    		}
    	})
    	$.ajax({
    		type: 'POST',
    		url: 'mainclass.php',
    		data: 'form=tblref_mall',
    		success: function(data){
    			$("#txtmall").html(data);
    			$("#txtmall2").html(data);
    		}, complete: function(){
    			loadfloorplanview();
				loadunits();
    		}
    	})

    	$(function(){
			$('.btnsortdash-floorplan').click(function(){
				if($(this).hasClass("fa-sort-up")){
					$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
					$("#FloorplanSortType").val("ASC");
					$("#FloorplanSortBy").val(this.id);
					loadfloorplan2();
				}
				else if($(this).hasClass("fa-sort-down")){
					$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
					$("#FloorplanSortType").val("DESC");
					$("#FloorplanSortBy").val(this.id);
					loadfloorplan2();
				}else if($(this).hasClass("fa-sort")){
					if($("#FloorplanSortType").val() == "ASC"){
						$(this).addClass("fa-sort-up").removeClass("fa-sort-down");
						$("#FloorplanSortType").val("DESC");
						$("#FloorplanSortBy").val(this.id);
						loadfloorplan2();
					}else{
						$(this).addClass("fa-sort-down").removeClass("fa-sort-up");
						$("#FloorplanSortType").val("ASC");
						$("#FloorplanSortBy").val(this.id);
						loadfloorplan2();
					}
				}
			});
		});
	});

	function loadwing(mallid){
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'mallid=' + mallid + '&form=loadwing',
			beforeSend:function(){
			},
			success: function(data) {
				$("#txtwing").html(data);
			}
		})
	}

	function selectview(type){
		if(type == "thumb"){
			$("#floorlist").css("display", "block");
			$("#div_floorlist2").css("display", "none");
			loadfloorplan();
		}else{
			$("#floorlist").css("display", "none");
			$("#div_floorlist2").css("display", "inline-table");
			loadfloorplan2();
		}
	}

	function loadfloorplanview(){
		var type = $("#changeview").val();
		if(type == "thumb"){
			$("#floorlist").css("display", "block");
			$("#div_floorlist2").css("display", "none");
			loadfloorplan();
		}else{
			$("#floorlist").css("display", "none");
			$("#div_floorlist2").css("display", "inline-table");
			loadfloorplan2();
		}
	}
	
	function loadfloorplan(){
		var mallid = $("#txtmall").val();
		var wingid = $("#txtwing").val();
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'mallid=' + mallid + '&wingid=' + wingid + '&form=loadfloorplan',
			beforeSend:function(){
				$(".myspinner").css("display", "block");
			},
			success: function(data) {
				$(".myspinner").css("display", "none");
				$("#floorlist").html(data);
				addfloorclick();
			}
		})
	}
	
	function loadfloorplan2(){
		var FloorplanSortBy = $('#FloorplanSortBy').val();
		var FloorplanSortType = $('#FloorplanSortType').val();
		var mallid = $("#txtmall").val();
		var wingid = $("#txtwing").val();
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'mallid=' + mallid + '&wingid=' + wingid + '&FloorplanSortBy=' + FloorplanSortBy + '&FloorplanSortType=' + FloorplanSortType + '&form=loadfloorplan2',
			beforeSend:function(){
				$(".myspinner").css("display", "block");
			},
			success: function(data){
				$(".myspinner").css("display", "none");
				$("#floorlist2").html(data);
				addfloorclick2();
			}
		})
	}
	
	function addfloorclick(){
		$("#floorlist li").each(function(){
			var obj = $(this);
			var arr = obj.attr("id").split("|");
			obj.find(".btnedit").click(function(){
				editfloor(arr[0], arr[1], arr[2]);
			});
			obj.find(".btndelete").click(function(){
				removefloor(arr[0]);
			});
		});
	}
	
	function addfloorclick2(){
		$("#floorlist2 tr").each(function(){
			var obj = $(this);
			obj.find("td").each(function(){
				var obj2 = $(this);
				obj2.click(function(){
					if(!$(this).hasClass("option")){ 
						viewdetails(obj.attr("id"), obj.find("td").eq(2).text()); 
					}
				});
			});
		});
	}
	
	function addfloorplan(){
		$("#txtmall2").val("");
		$("#txtwing2").val("");
		$("#txtfloor2").val("");
		$("#txtwing2").html("<option>-- Select Wing -- </option>");
		$("#txtfloor2").html("<option>-- Select Floor -- </option>");
		removephoto();
		$("#addfloorplan").modal("show");
	}

	function viewdetails(floorid, floorname){
		$("#div_main_cont").load("floorplan/floorplan4.php", {"floorid": floorid, "floorname": floorname});
		// $("#links li").removeClass("active");
		// $("#links li").eq(1).click(function(){
		// 	$("#div_main_cont").load("tenants/floorplan.php");
		// 	$("#links li").eq(2).remove();
		// 	$(this).addClass("active");
		// });
		// $("#links").append("<li class='active'><a href='#'>Floor Plan</a></li>");
	}
	
	function editfloor(floorid, mallid, wingid){
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'floorid=' + floorid + '&mallid=' + mallid + '&wingid=' + wingid + '&form=editfloor',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == ""){
					removephoto();
					$("#fpimg").attr("src", "#");
				}else{
					$("#fpimg").attr("src", "../Mall_Attachments/floorplan/"+ arr[1]);
					$("#fpimg").css("display", "block");
					$("#txtfpspan").css("display", "none");
					$("#txtfpclick").css("display", "none");
				}
				$("#txtmall2").val(arr[2]);
				$("#txtwing2").html(arr[3]);
				$("#txtfloor2").html(arr[4]);
				$("#addfloorplan").modal("show");
			},
			complete: function(){
				$("#txtwing2").val(wingid);
				$("#txtfloor2").val(floorid);
			}
		})
	}
	
	function removefloor(floorid){
		setTimeout(function(){
			showmodal("confirm", "Remove floor plan photo?", "removefloor2", floorid+"|", "", null, "0");
		}, 1000)
	}

	function removefloor2(floorid){
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'floorid=' + floorid + '&form=removefloor',
			success: function(data) {
				var arr = data.split("|");
				if(arr[1].trim() == "1"){
					setTimeout(function(){
						showmodal("alert", "Floor plan photo has been removed.", "loadfloorplan", null, "", null, "0");
					}, 1000)
				}else{ 
					setTimeout(function(){
                        showmodal("alert", arr[1], "", null, "", null, "1");
                    }, 500)
				}
			}
		})
	}

	function loadwing2(mallid){
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'mallid=' + mallid + '&form=loadwing',
			beforeSend:function(){
			},
			success: function(data) {
				$("#txtwing2").html(data);
				loadfloor2($("#txtwing2 option:first-child").val());
			}
		})
	}
	
	function loadfloor2(wingid){
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'wingid=' + wingid + '&form=loadfloor',
			beforeSend:function(){
			},
			success: function(data) {
				$("#txtfloor2").html(data);
			}
		})
	}
	
	function checkphoto(floorid){
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'floorid=' + floorid + '&form=checkphoto',
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1"){
					$("#fpimg").css("display", "block");
					$("#txtfpspan").css("display", "none");
					$("#txtfpclick").css("display", "none");
					$("#fpimg").attr("src", arr[2]);
				}else{
					$("#fpimg").attr("src", "#");
					$("#fpimg").css("display", "none");
					$("#txtfpspan").css("display", "block");
					$("#txtfpclick").css("display", "block");
					$("#txtimgfile").val("");
				}
			}
		})
	}
	
	function showimg(){
		var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById("txtimgfile").files[0]);
		oFReader.onload = function (oFREvent) {
			$("#fpimg").css("display", "block");
			$("#txtfpspan").css("display", "none");
			$("#txtfpclick").css("display", "none");
			document.getElementById("fpimg").src = oFREvent.target.result;
		};
	}
	
	function removephoto(){
		$("#fpimg").attr("src", "#");
		$("#fpimg").css("display", "none");
		$("#txtfpspan").css("display", "block");
		$("#txtfpclick").css("display", "block");
		$("#txtimgfile").val("");
	}

	function loadunits(){
		var key = $("#txtsearchunit").val();
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'floorid=<?php echo $_POST["floorid"]; ?>&key=' + key + '&form=loadunits2',
			success: function(data) {
				$("#unitlist").html(data);
			}
		})
	}
	
	function addunit(unitid, unitname, status){
		var coord = $("#txtcoord").val();
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'floorid=<?php echo $_POST["floorid"]; ?>&unitid=' + unitid + '&unitname=' + unitname + '&status=' + status + '&coord=' + coord + '&form=saveplot3',
			success: function(data) {
				if(data.trim() == "1"){
					setTimeout(function(){
						showmodal("alert", "Unit has been plotted.", "", null, "", null, "0");
                    }, 500)
					loadunits();
					loadpoints();
					$("#assignunit").modal("hide");
				}else{ 
					setTimeout(function(){
						showmodal("alert", data, "", null, "", null, "1");
                    }, 500)
				}
				
			}
		})
	}
	
	function updateunit(unitid){
		var coord = JSON.stringify(added.getGeometry().getCoordinates());
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'unitid=' + unitid + '&coord=' + coord + '&form=saveplot3',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				if(arr[1] == "1"){
					setTimeout(function(){
                        showmodal("alert", "Unit has been modified", "", null, "", null, "0");
                    }, 500)
					loadunits();
					loadpoints();
					$("#assignunit").modal("hide");
				}else{ 
					setTimeout(function(){
                        showmodal("alert", arr[1], "", null, "", null, "1");
                    }, 500)
				}
			}
		})
	}

	// FIRST TAB START
	function addpointclick(unitid){ 
		$("#txtunitid").val(unitid);
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'unitid=' + unitid + '&form=unitdetails',
			success: function(data) {
				var obj = JSON.parse(data);
				$("#lunitname").text(obj[0].UnitName);
				$("#lUnitType").text(obj[0].UnitType);
				$("#lUnitID").text(obj[0].UnitID);
				$("#lClassification").text(obj[0].Classification);
				$("#lDepartment").text(obj[0].Department);
				$("#lCategory").text(obj[0].Category);
				$("#lmall").text(obj[0].MallName);
				$("#lwing").text(obj[0].Wing);
				$("#lfloor").text(obj[0].Floor);
				$("#lArea").text(obj[0].Area + " SQM");
				$("#lRate").text(obj[0].Rate);
				$("#lAssocDues").text(obj[0].AssocDues);
				if(obj[0].WaterStat == "1"){ 
                    $("#txtwater").addClass("btn-info icon-animated-vertical"); 
                }else{ 
                    $("#txtwater").removeClass("btn-info icon-animated-vertical"); 
                }
                if(obj[0].ElectricStat == "1"){ 
                    $("#txtelectric").addClass("btn-yellow icon-animated-vertical"); 
                }else{ 
                    $("#txtelectric").removeClass("btn-yellow icon-animated-vertical"); 
                }
                if(obj[0].TxtStat == "1"){ 
                    $("#txtfileicon").addClass("btn-grey icon-animated-vertical"); 
                }else{ 
                    $("#txtfileicon").removeClass("btn-grey icon-animated-vertical"); 
                }
				$("#viewunit").modal("show");
			}
		})
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'unit_id=' + unitid + '&form=selected_unit_amenities',
			success: function(data) {
				$("#divFPAmenities").html(data);
			}
		})
		$.ajax({
    		type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
    		data: 'UnitID=' + unitid + '&form=FPUnitImages',
    		success: function(data){
    			$("#divFPUnitListContainer").html(data);
    		}, complete: function(){
	  			var colorbox_params = {
		          	rel: 'colorbox-FP' + unitid,
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
				$('[data-rel="colorbox-FP'+ unitid +'"]').colorbox(colorbox_params);
				$('#cboxLoadingGraphic').append("<i class='ace-icon fa fa-spinner orange'></i>");
	  		}
    	})
		$.ajax({
            type: 'POST',
            url: 'floorplan/mcp_mainclass.php',
            data: 'unitid=' + unitid + '&form=ctenantstat',
            success: function(data) {
                $("#ctenantlist").html(data);
            }
        })
	}
	// FIRST TAB END

	// SECOND TAB START
	function unitstat(){
        var unitid = $("#txtunitid").val();
        var startdate = $("#txtstartdate1").val();
        var enddate = $("#txtenddate1").val();
        var key = $("#txtsearchofunithistory").val();
        $.ajax({
            type: 'POST',
            url: 'floorplan/mcp_mainclass.php',
            data: 'unitid=' + unitid + '&startdate=' + startdate + '&enddate=' + enddate + '&key=' + key + '&form=unitstat',
            success: function(data) {
                $("#unitstatlist").html(data);
            }
        })
    }
	// SECOND TAB END

	// THIRD TAB START
    function tenantstat(){
        var unitid = $("#txtunitid").val();
        var startdate = $("#txtstartdate2").val();
        var enddate = $("#txtenddate2").val();
        var key = $("#txtsearchoftenanthistory").val();
        $.ajax({
            type: 'POST',
            url: 'floorplan/mcp_mainclass.php',
            data: 'key=' + key + '&unitid=' + unitid + '&startdate=' + startdate + '&enddate=' + enddate + '&form=tenantstat',
            success: function(data) {
                $("#tenantstatlist").html(data);
            }
        })
    }
	// THIRD TAB END

	// FOURTH TAB START
    function showFPInquiryHistory(){
        var key = $("#txtsearchinquiryhistory").val();
        var startdate = $("#txtstartdate3").val();
        var enddate = $("#txtenddate3").val();
        var UnitID = $("#txtunitid").val();
        $.ajax({
            type: 'POST',
            url: 'floorplan/mcp_mainclass.php',
            data: 'key=' + key + '&startdate=' + startdate + '&enddate=' + enddate + '&UnitID=' + UnitID + '&form=showFPInquiryHistory',
            success:function(data){
                $("#unitInquiryList").html(data);
            }
        })
    }

    function closenewFLoorPlanInquiry(){
        $("#modal_addnewinquiry").modal("hide");
        showFPInquiryHistory();
    }
	// FOURTH TAB END

	// FIFTH TAB START
    function showSOAList(){
		var UnitID = $("#txtunitid").val();
		var key = $("#txtsearchsoa").val();
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'key=' + key + '&UnitID=' + UnitID + '&form=showSOAList',
			success:function(data){
				$("#tblSoaList").html(data);
			}
		})
	}

	function opensoa_separatetenant(tenantid, soaid){
		$("#modal_opensoatenant").modal("show");
		$.ajax({
			type: 'POST',
			url: 'billing/billing/class.php',
			data: 'tenantid=' + tenantid + '&soaid=' + soaid + '&form=getTenantInfo',
			success: function(data) {
				var arr = data.split("|");
				$("#txtprint_storename").text(arr[0]);
				$("#txtprint_address").text(arr[1]);
				$("#txtprint_cutoff").text(arr[2]);
				// $("#print_footer").html(arr[3])
				$("#txtprint_billingperiod").text(arr[4]);
				$("#txtprint_assignee").text(arr[5]);
				$("#txtprint_billingnumber").text(arr[6]);
				// current charges
				$.ajax({
					type: 'POST',
					url: 'billing/billing/class.php',
					data: 'tenantid=' + tenantid + '&soaid=' + soaid + '&form=getCurrentCharges',
					success: function(data){
						$("#tblcurrchrges").html(data);
					}
				});
				// other charges
				$.ajax({
					type: 'POST',
					url: 'billing/billing/class.php',
					data: 'tenantid=' + tenantid + '&soaid=' + soaid + '&form=getOtherCharges',
					success:function(data){
						$("#tblotherchrges").html(data);
					}
				})
				// payments
				$.ajax({
					type: 'POST',
					url: 'billing/billing/class.php',
					data: 'tenantid=' + tenantid + '&soaid=' + soaid + '&form=getPayments',
					success: function(data){
						$("#tblpymentcrdtadj").html(data);
					}
				});
				// breakdowns
				$.ajax({
					type: 'POST',
					url: 'billing/billing/class.php',
					data: 'tenantid=' + tenantid + '&soaid=' + soaid + '&form=getBreakdowns',
					success: function(data){
						var arr = data.split("|");
						$("#ttlprevblncs").text(arr[0]);
						$("#ttlprevblncs2").text(arr[0]);
						$("#ttlcurrchrges2").text(arr[1]);
						$("#ttlcurrchrges").text(arr[1]);
						$("#ttlpymentcrdtadj").text(arr[2]);
						$("#ttlpymentcrdtadj2").text(arr[2]);
						$("#ttlpenalty").text(arr[3]);
						$("#ttlamtdue").text(arr[4]);
					}
				})
				// Aging
				$.ajax({
					type: 'POST',
					url: 'billing/billing/class.php',
					data: 'tenantid=' + tenantid + '&soaid=' + soaid + '&form=getAging',
					success:function(data){
						var arr = data.split("|");
						$("#txtsoab00").text(arr[0]);
						$("#txtsoab13").text(arr[1]);
						$("#txtsoab36").text(arr[2]);
						$("#txtsoab69").text(arr[3]);
						$("#txtsoab99").text(arr[4]);
					}
				})
				// SIGNATORIES
				$.ajax({
					type: 'POST',
					url: 'billing/billing/class.php',
					data: 'tenantid=' + tenantid + '&form=getSignatories',
					success:function(data){
						var arr = data.split("#");
						$("#lblprepby").text(arr[0]);
						$("#lblchkby").text(arr[1]);
						$("#lblapprby").text(arr[2]);
						$("#lblrcvdby").text(arr[3]);
					}
				})
			}
		})
		$.ajax({
            type: 'POST',
            url: 'mainclass.php',
            data: 'tenantid=' + tenantid + '&form=getheaderprint',
        	success:function(data){
                $("#template2").html(data);
            }
        })
	}

	function closemodalsoatenant(){
		$(".companyname").text("");
		$(".companyaddress").text("");
		$("#labelimg").attr("src", "");
		$("#txtprint_storename").text("")
		$("#txtprint_cutoff").text("")
		$("#txtprint_assignee").text("")
		$("#txtprint_address").text("")
		$("#tblcurrchrges").html("");
		$("#tblpymentcrdtadj").html("");
		$("#ttlprevblncs").text("");
		$("#ttlcurrchrges").text("");
		$("#ttlpymentcrdtadj").text("");
		$("#ttlprevblncs2").text("");
		$("#ttlcurrchrges2").text("");
		$("#ttlpymentcrdtadj2").text("");
		$("#ttlamtdue").text("");
		$("#ttlamtvat").text("");
		$("#modal_opensoatenant").modal("hide");
		$("#txtprint_billingperiod").text("");
	}
	
	function printsoa(){
		var toprint = $("#tblsoa2").html();
		var myheight = $(window).height()-40;
        var mywidth = $(window).width()-40;
        var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
		popupWin.document.open();
		popupWin.document.write("<html><head><title></title><style>*{font-family: 'Segoe UI', Tahoma, sans-serif; font-size:10px !important;}@media screen {div.divFooter {display: none;}}@media print { div.divFooter {position: fixed;bottom: 0;}}</style></head><body><div class='checklist'>" + toprint + "</div></body></html>");
		popupWin.print();
		popupWin.close();
	}
	// FIFTH TAB END

	// SIXTH TAB START
	function ShowMainLogs(){
		var UnitID = $("#txtunitid").val();
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'UnitID=' + UnitID + '&form=ShowMainLogs', 
			success:function(data){
				$("#tblwolist").html(data);
			}
		})
	}
	// SIXTH TAB END

	// SEVENTH TAB START
	function ShowComplaints(){
        var UnitID = $("#txtunitid").val();
        $.ajax({
            type: 'POST',
            url: 'floorplan/mcp_mainclass.php',
            data: 'UnitID=' + UnitID + '&form=ShowComplaints', 
            success:function(data){
                $("#tblfpComplaintsList").html(data);
            }
        })
    }
	// SEVENTH TAB END

	//EIGTH TAB START
	function loadincident(){
        var UnitID = $("#txtunitid").val();
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
            data: 'UnitID=' + UnitID + '&form=loadincident',
            success:function(data){
            	$("#tblfpincidentreports").html(data);
            }
		})
	}
	//EIGTH TAB END

	function checkaccessfirst2(module){
	    $.ajax({
		    type: 'POST',
		    url: 'mainclass.php',
		    data: 'module=' + module + '&form=checkaccessfirst',
		    success:function(data){
		        if(data == "viewunitcalendar"){
		          	viewcalendar();
		        }else if(data == "viewlcatenant"){
		          	selectnav(13);
		        }else if(data == "viewsettenant"){
		          	selectnav(14);
		        }else{
		          	showmodal("alert", "You are not allowed to access this feature.", "", null, "", null, "1");
		        }
		    }
	    })
 	}

	function viewcalendar(){
		$("#viewunit").modal("hide");
		setTimeout(function(){
			var unitid = $("#txtunitid").val();
			$("#div_main_cont").load("floorplan/mcp.php", {"unitid": unitid});
		}, 1000)
		// $("#links li").removeClass("active");
		// $("#links li").eq(1).click(function(){
		// 	$("#div_main_cont").load("tenants/floorplan2.php");
		// 	$("#links li").eq(2).remove();
		// 	$(this).addClass("active");
		// });
		// $("#links").append("<li class='active'><a href='#'>Calendar Schedules</a></li>");
	}
</script>