<script type="text/javascript">
	Number.prototype.number_format = function(c, d, t){
	    var n = this, 
	    c = isNaN(c = Math.abs(c)) ? 2 : c, 
	    d = d == undefined ? "." : d, 
	    t = t == undefined ? "," : t, 
	    s = n < 0 ? "-" : "", 
	    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
	    j = (j = i.length) > 3 ? j % 3 : 0;
	   	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	};
	$(function(){
    	$(".fixTable").tableHeadFixer(); 
    	$("#txtTSRPage").val("1");
    	$("#slcGraphYear").val("<?php echo date('Y'); ?>");
		$("#slcGraphYear2").val("<?php echo date('Y'); ?>");
		$("#slcGraphMonth").val("<?php echo date('m'); ?>");
		$(".date-picker").datepicker({
			autoHide: true,
			format: 'mm/dd/yyyy',
			todayHighlight: true
		})
		fncShowMall();
		clickforall();
		$("#txtSearchTenantName").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				clickforall(); 
			}else if(x == '8'){
                if($('#txtSearchTenantName').val() == ""){
                    clickforall();
                }
            }
		});
		$("#txtSearchTenant").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				fncLoadTenantList(); 
			}else if(x == '8'){
                if($('#txtSearchTenant').val() == ""){
                    fncLoadTenantList();
                }
            }
		});
		$("#chkReportView").click(function(){
			if($(this).is(":checked")){
				$(".div_ListVIew").css("display", "none");
				$(".div_GraphView").css("display", "block");
				$("#chkGraphYear").click();
				fncLoadTenantList();
			}else{
				$(".div_ListVIew").css("display", "block");
				$(".div_GraphView").css("display", "none");
			}
		})
		$(".div_ListVIew").css("display", "block");
		$(".div_GraphView").css("display", "none");

		// ruth
		$('#pdailysales').css("display", "inline-block");
		$('#phrsales').css("display", "none");
		$('#ppayment').css("display", "none");
		$('#pdiscount').css("display", "none");
		$('#prefund').css("display", "none");
		// ruth
	})

	function fncShowMall(){
		$.ajax ({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success: function(data){
				$(".selectMall").html(data);
			}
		})
	}

	function showSales(){
		$(".reportlists").css("display", "none");
		$(".paginationLists").css("display", "none");
		$("#showSales").css("display", "block");
		$("#pageSales").css("display", "block");
    	$("#txtTSRPage").val("1");
		dbSales();
	}

	function showHour(){
		$(".reportlists").css("display", "none");
		$(".paginationLists").css("display", "none");
		$("#showHour").css("display", "block");
		$("#pageHour").css("display", "block");
    	$("#txtTSRPage").val("1");
		dbHour();
	}

	function showPayment(){
		$(".reportlists").css("display", "none");
		$(".paginationLists").css("display", "none");
		$("#showPayment").css("display", "block");
		$("#pagePayment").css("display", "block");
    	$("#txtTSRPage").val("1");
		dbPayment();
	}

	function showDiscount(){
		$(".reportlists").css("display", "none");
		$(".paginationLists").css("display", "none");
		$("#showDiscount").css("display", "block");
		$("#pageDiscount").css("display", "block");
    	$("#txtTSRPage").val("1");
		dbDiscount();
	}

	function showCanceled(){
		$(".reportlists").css("display", "none");
		$(".paginationLists").css("display", "none");
		$("#showVoid").css("display", "block");
		$("#pageVoid").css("display", "block");
    	$("#txtTSRPage").val("1");
		dbVoid();
	}

	function clickforall(){
    	$("#txtTSRPage").val("1");
		$(".selectedtab li").each(function(){
			id = $(this).attr("id");
			if($("#"+id).hasClass("active")){
				tab = $(this).attr("id");
			}
		})
		if(tab == "tabsales"){
			dbSales();
			dbSales_Total();
		}else if(tab == "tabhourlysales"){
			dbHour();
		}else if(tab == "tabpayment"){
			dbPayment();
		}else if(tab == "tabdiscount"){
			dbDiscount();
		}else if(tab == "tabvoid"){
			dbVoid();
		}
	}

	function dbSales(){
	    var page = $("#txtTSRPage").val();
		var MallID = $("#txtTSRMall").val();
		var key = $("#txtSearchTenantName").val();
		var DateFrom = $("#dateFromList").val();
		var DateTo = $("#dateToList").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'key=' + key + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&page=' + page + '&MallID=' + MallID +  '&form=dbSales',
			success: function(data){
				if(data != ""){
		          	$("#db_sales").html(data);
		        }else{
		          	$("#db_sales").html("<tr><td colspan='31' style='text-align: center;'>No Data Found...</td></tr>");
		        }
				fncTSREntries('dbSales');
				fncTSRPage('dbSales');
			}
		})
	}

	function dbSales_Total(){
		var MallID = $("#txtTSRMall").val();
		var key = $("#txtSearchTenantName").val();
		var DateFrom = $("#dateFromList").val();
		var DateTo = $("#dateToList").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'key=' + key + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&MallID=' + MallID +  '&form=dbSales_Total',
			success: function(data){
				var arr = data.split("|");
				$("#thOldGrandTotal").text(arr[0]);
				$("#thNewGrandTotal").text(arr[1]);
				$("#thDailySales").text(arr[2]);
				$("#thGrandTotalDiscount").text(arr[3]);
				$("#thTotalDiscountSenior").text(arr[4]);
				$("#thTotalDiscountPWD").text(arr[5]);
				$("#thTotalDiscountGPC").text(arr[6]);
				$("#thTotalDiscountVIP").text(arr[7]);
				$("#thTotalDiscountEMP").text(arr[8]);
				$("#thTotalDiscountREG").text(arr[9]);
				$("#thTotalDiscountOTHERS").text(arr[10]);
				$("#thTotalRefund").text(arr[11]);
				$("#thTotalCancelled").text(arr[12]);
				$("#thVAT").text(arr[13]);
				$("#thVATInclusiveSales").text(arr[14]);
				$("#thVATExclusiveSales").text(arr[15]);
				$("#thDocumentCount").text(arr[16]);
				$("#thCustomerCount").text(arr[17]);
				$("#thSeniorCitizenCount").text(arr[18]);
				$("#thLocalTax").text(arr[19]);
				$("#thServiceCharge").text(arr[20]);
				$("#thTotalSalesNonVat").text(arr[21]);
				$("#thRawGross").text(arr[22]);
				$("#thDailyLocalTax").text(arr[23]);
				$("#thTotalPaymentCash").text(arr[24]);
				$("#thTotalPaymentCard").text(arr[25]);
				$("#thTotalPaymentOthers").text(arr[26]);
			}
		})
	}

	function dbHour(){
	    var page = $("#txtTSRPage").val();
		var MallID = $("#txtTSRMall").val();
		var key = $("#txtSearchTenantName").val();
		var DateFrom = $("#dateFromList").val();
		var DateTo = $("#dateToList").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'key=' + key + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&page=' + page + '&MallID=' + MallID +   '&form=dbHour',
			success: function(data){
				if(data != ""){
		          	$("#db_hour").html(data);
		        }else{
		          	$("#db_hour").html("<tr><td colspan='7' style='text-align: center;'>No Data Found...</td></tr>");
		        }
				fncTSREntries('dbHour');
				fncTSRPage('dbHour');
			}
		})
	}

	function dbPayment(){
	    var page = $("#txtTSRPage").val();
		var MallID = $("#txtTSRMall").val();
		var key = $("#txtSearchTenantName").val();
		var DateFrom = $("#dateFromList").val();
		var DateTo = $("#dateToList").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'key=' + key + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&page=' + page + '&MallID=' + MallID +  '&form=dbPayment',
			success: function(data){
				if(data != ""){
		          	$("#db_payment").html(data);
		        }else{
		          	$("#db_payment").html("<tr><td colspan='7' style='text-align: center;'>No Data Found...</td></tr>");
		        }
				fncTSREntries('dbPayment');
				fncTSRPage('dbPayment');
			}
		})
	}

	function dbDiscount(){
	    var page = $("#txtTSRPage").val();
		var MallID = $("#txtTSRMall").val();
		var key = $("#txtSearchTenantName").val();
		var DateFrom = $("#dateFromList").val();
		var DateTo = $("#dateToList").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'key=' + key + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&page=' + page + '&MallID=' + MallID +  '&form=dbDiscount',
			success: function(data){
				if(data != ""){
		          	$("#db_discount").html(data);
		        }else{
		          	$("#db_discount").html("<tr><td colspan='8' style='text-align: center;'>No Data Found...</td></tr>");
		        }
				fncTSREntries('dbDiscount');
				fncTSRPage('dbDiscount');
			}
		})
	}

	function dbVoid(){
	    var page = $("#txtTSRPage").val();
		var MallID = $("#txtTSRMall").val();
		var key = $("#txtSearchTenantName").val();
		var DateFrom = $("#dateFromList").val();
		var DateTo = $("#dateToList").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'key=' + key + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&page=' + page + '&MallID=' + MallID + '&form=dbVoid',
			success: function(data){
				if(data != ""){
		          	$("#db_void").html(data);
		        }else{
		          	$("#db_void").html("<tr><td colspan='8' style='text-align: center;'>No Data Found...</td></tr>");
		        }
				fncTSREntries('dbVoid');
				fncTSRPage('dbVoid');
			}
		})
	}

	function fncTSREntries(ReportType){
	    var page = $("#txtTSRPage").val();
	    var MallID = $("#txtTSRMall").val();
		var key = $("#txtSearchTenantName").val();
		var DateFrom = $("#dateFromList").val();
		var DateTo = $("#dateToList").val();
	    $.ajax({
	        type: 'POST',
	        url: 'reports/tenantsalesreport/class.php',
	        data: 'key=' + key + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&page=' + page + '&MallID=' + MallID + '&ReportType=' + ReportType + '&form=fncTSREntries',
	        success: function(data){
	            $("#txtTSREntries").text(data);
	        }
	    });
	}

	function fncTSRPage(ReportType){
	    var page = $("#txtTSRPage").val();
	   	var MallID = $("#txtTSRMall").val();
		var key = $("#txtSearchTenantName").val();
		var DateFrom = $("#dateFromList").val();
		var DateTo = $("#dateToList").val();
	    $.ajax({
	        type: 'POST',
	        url: 'reports/tenantsalesreport/class.php',
	        data: 'key=' + key + '&DateFrom=' + DateFrom + '&DateTo=' + DateTo + '&page=' + page + '&MallID=' + MallID + '&ReportType=' + ReportType + '&form=fncTSRPage',
	        success: function(data){
	            $("#txtTSRPagination").html(data);
	        }
	    });
	}

    function TSRPagination(PageTSRList, PageNumTSRList, ReportType){
        $(".pgNumTSRList").removeClass("active");
        $("#pgTSRList" + PageNumTSRList).addClass("active");
        $("#txtTSRPage").val(PageTSRList);
		if(ReportType == "dbSales"){
			dbSales();
		}else if(ReportType == "dbHour"){
			dbHour();
		}else if(ReportType == "dbPayment"){
			dbPayment();
		}else if(ReportType == "dbDiscount"){
			dbDiscount();
		}else if(ReportType == "dbVoid"){
			dbVoid();
		}
    }

    function fncYearlyGraph(){
		$(".slcYearlyView").prop("disabled", false);
		$(".slcMonthlyView").prop("disabled", true);
		$(".div_GraphYearly").css("display", "inline-block");
		$(".div_GraphMonthly").css("display", "none");
    }

    function fncMonthlyGraph(){
		$(".slcMonthlyView").prop("disabled", false);
		$(".div_GraphYearly").css("display", "none");
		$(".div_GraphMonthly").css("display", "inline-block");
    }

    function fncLoadTenantList(){
    	var MallID = $("#txtTSRMallGraph").val();
		var key = $("#txtSearchTenant").val();
		$.ajax({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'key=' + key + '&MallID=' + MallID + '&form=fncLoadTenantList',
			success:function(data){
				$("#olTenantList").html(data);
				$("#olTenantList li").each(function(){
					$(this).click(function(){
						if($(this).hasClass("MonthlyGraphTenant")){
							$("#olTenantList li").removeClass("MonthlyGraphTenant");
							$("#olTenantList li").find(".dd2-content").css("background-color", "#F8FAFF");
							$("#olTenantList li").find(".dd2-content").css("color", "#7C9EB2");
						}else{
							$("#olTenantList li").removeClass("MonthlyGraphTenant");
							$("#olTenantList li").find(".dd2-content").css("background-color", "#F8FAFF");
							$("#olTenantList li").find(".dd2-content").css("color", "#7C9EB2");
							$(this).find(".dd2-content").css("background-color", "#666");
							$(this).find(".dd2-content").css("color", "#FFF");
							$(this).addClass("MonthlyGraphTenant");
						}
					})
				})
			}
		})
	}

    function fncProceedLoadingGraphicalView(){
    	var key = $("#txtSearchMonthTenantName").val();
    	if($("#chkGraphYear").is(":checked")){
			loadpmix2();
			setTimeout(function(){
				fncLoadTreeMapData();
			}, 2000)
			fncTotalYearSales();
    	}else{
			fncPieChartContainter();
			fncDailySalesGraph();
    	}
    }

	var TreeMapCurrentPage = 0;
	var TreeMapData = [];
    function fncLoadTreeMapData(){
		TreeMapData = [];
		var GraphYear = $("#slcGraphYear").val();
		$.ajax({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'TreeMapCurrentPage=' + TreeMapCurrentPage + '&GraphYear=' + GraphYear + '&form=fncLoadTreeMapData',
			success: function(data) {
				var arr = data.split("#");
				for(var i=1; i<=arr.length-1; i++){
					var arr2 = arr[i].split("|");
					TreeMapData.push({ id: arr2[1], name: "<b>" + arr2[2] + "</b>", value: parseFloat(arr2[3]) });
					TreeMapData.push({ name: "<b>" + arr2[2] + "</b>", parent: arr2[1], value: parseFloat(arr2[3]) });
					if(i == arr.length-1){
						var chart = $("#divTreeMap").highcharts();
						chart.series[0].setData(TreeMapData);
					}
				}
				var arr3 = arr[1].split("|");
				$("#txtTreeMapPageCount").val(arr3[4]);
				if(arr3[4] == 0){
					$(".btnTreeMapPrev").css("display", "none"); 
					$(".btnTreeMapNext").css("display", "none"); 
				}else{
					if(TreeMapCurrentPage == 0){
						$(".btnTreeMapPrev").css("display", "none"); 
						$(".btnTreeMapNext").css("display", "block"); 
					}else if(TreeMapCurrentPage == $("#txtTreeMapPageCount").val() * 20){
						$(".btnTreeMapPrev").css("display", "block"); 
						$(".btnTreeMapNext").css("display", "none"); 
					}else{
						$(".btnTreeMapPrev").css("display", "block"); 
						$(".btnTreeMapNext").css("display", "block"); 
					}
				}
			}
		})
    }

    function fncChangePage(Action){
		if(Action == 'prev'){
			TreeMapCurrentPage = TreeMapCurrentPage - 20;
			fncLoadTreeMapData();
		}else if(Action == "next"){
			TreeMapCurrentPage = TreeMapCurrentPage + 20;
			fncLoadTreeMapData();
		}
	}

    function loadpmix2(){
		setTimeout(function(){
			$("#divTreeMap").highcharts({
				chart: {
					renderTo: "divTreeMap",
					animation: {
						duration: 500
					}
				},
				credits: {
					enabled: false
				},
				exporting: {
					enabled: false
				},
				series: [{
					type: "treemap",
					drillUpButton: {
						text: " Back",
						itemStyle: {
							fontWeight: 400,
							color: "#666"
						},
						position: {
							align: 'right',
							x: -10
						},
						theme: {
							fill: "white",
							"stroke-width": 1,
							stroke: 'silver',
							r: 2,
							states: {
								hover: {
									fill: "#bada55"
								}
							}
						}
					},
					layoutAlgorithm: "strip",
					animation: true,
					allowDrillToNode: true,
					colorByPoint: true,
					alternateStartingDirection: false,
					levels: [{
						level: 1,
						borderWidth: 2,
						borderColor: "#CCC",
						dataLabels: {
							enabled: true,
							verticalAlign: "top",
							padding: 10,
							allowOverlap: false,
							formatter:function(){
								return this.series.data[this.point.x].name+"<br>"+(this.series.data[this.point.x].value).number_format(2,'.',',');
							}
						}
					}, {
						level: 2,
						borderWidth: 2,
						borderColor: "#CCC",
						dataLabels: {
							enabled: true,
							verticalAlign: "top",
							padding: 10,
							allowOverlap: false,
							formatter:function(){
								return this.series.data[this.point.x].name+"<br>"+(this.series.data[this.point.x].value).number_format(2,'.',',');
							}
						}
					}],
					data: TreeMapData
				}],
				title: {
					text: 'Total Sales of All Tenant for ' + $("#slcGraphYear").val()
				}
			});
		}, 2000)
	}

	function fncTotalYearSales(){
		var TenantID = $(".MonthlyGraphTenant").attr("id");
		var MallID = $("#txtTSRMall").val();
		var GraphYear = $("#slcGraphYear").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'TenantID=' + TenantID + '&MallID=' + MallID + '&GraphYear=' + GraphYear + '&form=fncTotalYearSales',
			success: function(data){
				$("#tblWholeYearSales").html(data);
			}
		})
	}

	function fncMonthPie(){
		var MallID = $("#txtTSRMallGraph").val();
		var year = $("#slcGraphYear").val();
		var month = $("#slcGraphMonth").val();
		var TenantID = $(".MonthlyGraphTenant").attr("id");
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'reports/tenantsalesreport/class.php',
			data: 'year=' + year + '&month=' + month + '&TenantID=' + TenantID + '&MallID=' + MallID + '&form=fncMonthPie', 
			success: function(data){
				arr = data;      
			}
		}); 
		return arr;
	}

	var mgaBuwan = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

	function fncgetTenantName(){
		var TenantID = $(".MonthlyGraphTenant").attr("id");
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'reports/tenantsalesreport/class.php',
			data: 'TenantID=' + TenantID + '&form=getTenantName',
			success: function(data){
				arr = data;
			}
		})
		return arr;
	}

	function fncPieChartContainter(){
		var TenantName = fncgetTenantName();
		var arrdata = JSON.parse(fncMonthPie());
		var monthName = "";
		var tenantName2 = "";
		if(TenantName == ""){
			tenantName2 = "All Stores";
			monthName = mgaBuwan[Number($("#slcGraphMonth").val())] + ", " + $("#slcGraphYear").val();
		}else{
			tenantName2 = TenantName;
			monthName = mgaBuwan[Number($("#slcGraphMonth").val())] + ", " + $("#slcGraphYear").val();
		}
		chart = new Highcharts.Chart({
			credits: {
				enabled: false
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px"></span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0"><span style="font-size:15px"> {point.name}: </span></td>' +
					'<td style="padding:0"><span style="font-size:15px;font-weight:bold;"> {point.y} Php</span></td></tr>',
				footerFormat: '</table>',
		        valueDecimals: 2,
        		valuePrefix: 'P',
		    },
			series:[{
				"data": arrdata,
				type: 'pie',
		        height: 520,
				animation: false,
				point:{
					events:{
						click: function (event) {
							previewSalesTbl(this.id, this.name);
						}
					}
				}  
			}],
			legend: {
				layout: 'vertical',
				align: 'right',
				floating: true,
				backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
			},
			plotOptions: {
				pie: {
					size: '100%',
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
					},
					showInLegend: true
				}
			},
			"chart":{
				"renderTo":"divMonthlySales"
			},
			title: {
				text: tenantName2 + '<br>Monthly Sales<br>' + monthName
			},
		});
	}

	function previewSalesTbl(TenantID, ReportType){
		if(ReportType == "Sales"){
			$(".divMonthlySalesBreakdown").css("display", "inline-block");
			$("#thListPtype").text("Payment Type");
		}else if(ReportType == "Void"){
			$(".divMonthlySalesBreakdown").css("display", "inline-block");
			$("#thListPtype").text("Void / Refund");
		}else if(ReportType == "Discount"){
			$(".divMonthlySalesBreakdown").css("display", "inline-block");
			$("#thListPtype").text("Discount Type");
		}else{
			$(".divMonthlySalesBreakdown").css("display", "none");
		}
		$('#listPtypeAmount').html(fncShowTableInfo(TenantID, ReportType));
	}

	function fncShowTableInfo(TenantID, ReportType){
		var year = $("#slcGraphYear").val();
		var month = $("#slcGraphMonth").val();
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'reports/tenantsalesreport/class.php',
			data: 'year=' + year + '&month=' + month + '&TenantID=' + TenantID + '&ReportType=' + ReportType + '&form=fncShowTableInfo', 
			success: function(data){
				arr = data;      
			}
		}); 
		return arr;
	}

	function fncNumofDays(){
		var year = $("#slcGraphYear").val();
		var month = $("#slcGraphMonth").val();
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'reports/tenantsalesreport/class.php',
			data: 'year=' + year + '&month=' + month + '&form=fncNumofDays', 
			success: function(data){
				arr = data;      
			}
		}); 
		return arr;
	}

	function getMonthSales(){
		var MallID = $("#txtTSRMallGraph").val();
		var TenantID = $(".MonthlyGraphTenant").attr("id");
		var year = $("#slcGraphYear").val();
		var month = $("#slcGraphMonth").val();
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'reports/tenantsalesreport/class.php',
			data: 'year=' + year + '&month=' + month + '&TenantID=' + TenantID + '&MallID=' + MallID + '&form=getMonthSales', 
			success: function(data){
				arr = data;      
			}
		}); 
		return arr;
	}

	function getMonthDiscount(){
		var MallID = $("#txtTSRMallGraph").val();
		var TenantID = $(".MonthlyGraphTenant").attr("id");
		var year = $("#slcGraphYear").val();
		var month = $("#slcGraphMonth").val();
		var arr = '';
		$.ajax({
			type:'POST',
			async:false,
			url:'reports/tenantsalesreport/class.php',
			data: 'year=' + year + '&month=' + month + '&TenantID=' + TenantID + '&MallID=' + MallID + '&form=getMonthDiscount', 
			success:function(data){
				arr = data;      
			}
		}); 
		return arr;
	}

	function getMonthVoid(){
		var MallID = $("#txtTSRMallGraph").val();
		var TenantID = $(".MonthlyGraphTenant").attr("id");
		var year = $("#slcGraphYear").val();
		var month = $("#slcGraphMonth").val();
		var arr = '';
		$.ajax({
			type:'POST',
			async:false,
			url:'reports/tenantsalesreport/class.php',
			data: 'year=' + year + '&month=' + month + '&TenantID=' + TenantID + '&MallID=' + MallID + '&form=getMonthVoid', 
			success:function(data){
				arr = data;      
			}
		}); 
		return arr;
	}

	function fncDailySalesGraph(){
		Highcharts.setOptions({
			lang: {
				decimalPoint: '.',
				thousandsSep: ','
			}
		});
		var TenantName = fncgetTenantName();
		var tenantName2 = "";
		var monthName = "";
		if(TenantName == ""){
			tenantName2 = "All Tenants";
			monthName = mgaBuwan[Number($("#slcGraphMonth").val())] + " " + $("#slcGraphYear").val();
		}else{
			tenantName2 = TenantName;
			monthName = mgaBuwan[Number($("#slcGraphMonth").val())] + " " + $("#slcGraphYear").val();
		}
		var arrdata = JSON.parse(getMonthSales());
		var arrdata2 = JSON.parse(fncNumofDays());
		var arrdata3 = JSON.parse(getMonthDiscount());
		var arrdata4 = JSON.parse(getMonthVoid());
		Highcharts.chart('divDailySales',{
			credits: {
				enabled: false
			},
			chart: {
				type: 'areaspline'
			},
			title: {
				text: tenantName2 + '<br>Daily Sales<br>' + monthName
			},
			subtitle: {
				
			},
			xAxis: {
				categories: arrdata2,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Php'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px"></span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0"><span style="font-size:15px"> {series.name}: </span></td>' +
					'<td style="padding:0"><span style="font-size:15px;font-weight:bold;"> {point.y:,.1f} Php</span></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Sales',
				data: arrdata,
				color: "#3bc0c3",
				point:{
					events:{
						click: function(event){
							openDaily(Number(this.x) + 1, "Sales");
						}
					}
				},
			}, {
				name: 'Discount',
				data: arrdata3,
				color: "#dcdcdc",
				point:{
					events:{
						click: function(event){
							openDaily(Number(this.x) + 1, "Discount");
						}
					}
				},
			}, {
				name: 'Void',
				data: arrdata4,
				color: "#1a2942",
				point:{
					events:{
						click: function(event){
							openDaily(Number(this.x) + 1, "Sales");
						}
					}
				},
			}]
		});
	}

	function openDaily(dayNum, type){
		var TenantID = $(".MonthlyGraphTenant").attr("id");
		var year = $("#slcGraphYear").val();
		var month = $("#slcGraphMonth").val();
		var MallID = $("#txtTSRMallGraph").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'TenantID=' + TenantID + '&year=' + year + '&month=' + month + '&dayNum=' + dayNum + '&MallID=' + MallID + '&form=perhourtbl',
			success: function(data){
				if(data == ""){
					$("#perhourtbl").html("");
					$("#txtDayNum").val("");
				}else{
					$("#mdlFordaily").modal("show");
					$("#perhourtbl").html(data);
					$("#txtDayNum").val(dayNum);
				}
			}
		})
	}

	function fncshowList(){
		$(".divHouryList").css('display', 'block');
		$(".divHouryGraph").css('display', 'none');
	}

	function fncshowGraph(){
		$(".divHouryList").css('display', 'none');
		$(".divHouryGraph").css('display', 'block');
		setTimeout(function(){
			hourly();
		}, 1000)
	}

	function getHourlySales(){
		var TenantID = $(".MonthlyGraphTenant").attr("id");
		var dayNum = $("#txtDayNum").val();
		var year = $("#slcGraphYear").val();
		var month = $("#slcGraphMonth").val();
		var MallID = $("#txtTSRMallGraph").val();
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'reports/tenantsalesreport/class.php',
			data: 'year=' + year + '&month=' + month + '&dayNum=' + dayNum + '&TenantID=' + TenantID + '&MallID=' + MallID + '&form=getHourlySales', 
			success:function(data){
				arr = data;      
			}
		}); 
		return arr;
	}

	function hourly(){
		Highcharts.setOptions({
			lang: {
				decimalPoint: '.',
				thousandsSep: ','
			}
		});
		var dayNum = $("#txtDayNum").val();
		var tenantName = fncgetTenantName();
		var tenantName2 = "";
		if(tenantName == ""){
			tenantName2 = " of All Tenants<br>for " + mgaBuwan[Number($("#slcGraphMonth").val())] + " " + dayNum + ", " + $("#slcGraphYear").val();
		}else{
			tenantName2 = " of " + fncgetTenantName() + "<br>for " + mgaBuwan[Number($("#slcGraphMonth").val())] + " " + dayNum + ", " + $("#slcGraphYear").val();
		}
		var arrdata = JSON.parse(getHourlySales());
		Highcharts.chart('graphHourly', {
			credits: {
				enabled: false
			},
			chart: {
				type: 'bar',
			    height: 650
			},
			title: {
				text: 'Hourly Sales ' + tenantName2
			},
			subtitle: {
				
			},
			xAxis: {
				type: 'category'
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Php'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:18px;">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0"><span style="font-size:15px"> {series.name}: </span></td>' +
					'<td style="padding:0"><span style="font-size:15px;font-weight:bold;"> {point.y:,.1f} Php</span></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				size: '100%',
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Sales',
				data: arrdata,
				color: "#3bc0c3",
			}]
		});
	}

	// ruth
	function AutoConsolidatedailysales(){
		var tenant = $('#txtSearchTenantName').val();
		var datefrom = $('#dateFromList').val();
		var dateto = $('#dateToList').val();
		var mallid = $("#txtTSRMall").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'tenant=' + tenant + '&datefrom=' + datefrom + '&dateto=' + dateto + '&mallid=' + mallid + '&form=AutoConsolidatedailysales',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Daily Sales successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export daily sales.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	} 

	function AutoConsolidatehourlysales(){
		var tenant = $('#txtSearchTenantName').val();
		var datefrom = $('#dateFromList').val();
		var dateto = $('#dateToList').val();
		var mallid = $("#txtTSRMall").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'tenant=' + tenant + '&datefrom=' + datefrom + '&dateto=' + dateto + '&mallid=' + mallid + '&form=AutoConsolidatehourlysales',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Hourly Sales successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export hourly sales.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	} 

	function AutoConsolidatepayment(){
		var tenant = $('#txtSearchTenantName').val();
		var datefrom = $('#dateFromList').val();
		var dateto = $('#dateToList').val();
		var mallid = $("#txtTSRMall").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'tenant=' + tenant + '&datefrom=' + datefrom + '&dateto=' + dateto + '&mallid=' + mallid + '&form=AutoConsolidatepayment',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Daily Sales Payment successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export Daily Sales Payment.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	} 

	function AutoConsolidatediscount(){
		var tenant = $('#txtSearchTenantName').val();
		var datefrom = $('#dateFromList').val();
		var dateto = $('#dateToList').val();
		var mallid = $("#txtTSRMall").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'tenant=' + tenant + '&datefrom=' + datefrom + '&dateto=' + dateto + '&mallid=' + mallid + '&form=AutoConsolidatediscount',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Daily Sales Discount successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export Daily Discount Payment.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	} 

	function AutoConsolidaterefund(){
		var tenant = $('#txtSearchTenantName').val();
		var datefrom = $('#dateFromList').val();
		var dateto = $('#dateToList').val();
		var mallid = $("#txtTSRMall").val();
		$.ajax ({
			type: 'POST',
			url: 'reports/tenantsalesreport/class.php',
			data: 'tenant=' + tenant + '&datefrom=' + datefrom + '&dateto=' + dateto + '&mallid=' + mallid + '&form=AutoConsolidaterefund',
			success: function (data) {
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Daily Sales Refund/Cancelled successfully exported.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to export Daily Sales Refund/Cancelled.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	} 
	
	function getheaderprint(mallid,classN,condition){
			var cond = JSON.parse( condition ).join('&');
			var toprint = "";
			$.ajax({
	            type: 'POST',
	            url: 'mainclass.php',
	            data: 'mallID=' + mallid + '&form=getheaderprint',
	            success:function(data){
	                $("#printable_divtemplate").html(data);
	            }, complete: function(){
	            	$.ajax({
	            		type: 'POST',
			            url: 'reports/tenantsalesreport/class.php',
			            data: cond + '&form='+classN,
			            success:function(data){
			            	 $("#printable_div_content").html(data);
			                toprint = $("#printable_div").html();	
			            	var myheight = $(window).height()-40;
			                var mywidth = $(window).width()-40;
			                var popupWin = window.open("", "_blank", "height=" + myheight + ",width=" + mywidth + ",location=no,scrollbars=1,left=" + 20);
			                popupWin.document.open();
			                popupWin.document.write("<html><head><link rel='stylesheet' href='assets/css/bootstrap.min.css' /><title></title></head><body onload='window.print();'>" + toprint + "</body></html>");
			                popupWin.document.close();
			            }
	                })
	            }
	        })
		}
// ruth
</script>