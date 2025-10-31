<?php 
	session_start(); 
	$st = mysql_fetch_array(mysql_query("SELECT softwaretype FROM tblsys_setup", $connection)); 
?>
<script type="text/javascript">
	$(function(){
        $(".fixTable").tableHeadFixer();
        <?php if($st['softwaretype'] == 0){ ?>
			ShowPanelValPage1();
			showdashapprovalpending();
			MonthlyTotalSalesFromTenantsGraph();
			ShowListOfTopTenants();
			MonthlyOccupancyReportGraph();
			OccpancyBasedonClassificationGraph();
			VacancyBasedonClassificationGraph();
			MonthlyTotalRevenueFromLeaseGraph();
			MonthlySetGraph();
			MonthlyLCAGraph();
			loadMallref();
			loadWingref();
			loadFloorref();
			loadClassificationref();
			loadDepartmentref();
			loadCategoryref();
        <?php }else if($st['softwaretype'] == 1){ ?>
        	ShowPanelValPage1();
        	showdashapprovalpending();
			MonthlyOccupancyReportGraph();
			OccpancyBasedonClassificationGraph();
			VacancyBasedonClassificationGraph();
			MonthlyTotalRevenueFromLeaseGraph();
			MonthlySetGraph();
			MonthlyLCAGraph();
			loadMallref();
			loadWingref();
			loadFloorref();
			loadClassificationref();
			loadDepartmentref();
			loadCategoryref();
        <?php }else if($st['softwaretype'] == 2){ ?>	
        	ShowPanelValPage2();
			MonthlyAverageTurnAroundTimeWOGraph();
			MonthlyAverageTurnAroundTimeComplaintsGraph();
			MonthlyAverageTurnAroundTimeIRGraph();
			ShowWorkOrderLogs();
			MonthlyWorkOrdersGraph();
			MonthlyComplaintsGraph();
			MonthlyIncidentReportsGraph();
			MaintenanceBudgetGraph();
			MonthlyConsumptionofElectricReportGraph();
			MonthlyConsumptionofWaterReportGraph();
			MonthlyThirdPartyContractorsGraph();
        <?php }else if($st['softwaretype'] == 3){ ?>
        	ShowPanelValPage1();
        	showdashapprovalpending();
			MonthlyOccupancyReportGraph();
			OccpancyBasedonClassificationGraph();
			VacancyBasedonClassificationGraph();
			MonthlyTotalRevenueFromLeaseGraph();
			MonthlySetGraph();
			MonthlyLCAGraph();
			loadMallref();
			loadWingref();
			loadFloorref();
			loadClassificationref();
			loadDepartmentref();
			loadCategoryref();
        <?php }else if($st['softwaretype'] == 4){ ?>
        	ShowPanelValPage1();
        	showdashapprovalpending();
			MonthlyOccupancyReportGraph();
			OccpancyBasedonClassificationGraph();
			VacancyBasedonClassificationGraph();
			MonthlyTotalRevenueFromLeaseGraph();
			MonthlySetGraph();
			MonthlyLCAGraph();
			loadMallref();
			loadWingref();
			loadFloorref();
			loadClassificationref();
			loadDepartmentref();
			loadCategoryref();
        <?php }else if($st['softwaretype'] == 5){ ?>
        	ShowPanelValPage1();
        	showdashapprovalpending();
			MonthlyOccupancyReportGraph();
			OccpancyBasedonClassificationGraph();
			VacancyBasedonClassificationGraph();
			MonthlyTotalRevenueFromLeaseGraph();
			MonthlySetGraph();
			MonthlyLCAGraph();
			loadMallref();
			loadWingref();
			loadFloorref();
			loadClassificationref();
			loadDepartmentref();
			loadCategoryref();
        <?php }else{ ?>
        	ShowPanelValPage1();
        	showdashapprovalpending();
			MonthlyOccupancyReportGraph();
			OccpancyBasedonClassificationGraph();
			VacancyBasedonClassificationGraph();
			MonthlyTotalRevenueFromLeaseGraph();
			MonthlySetGraph();
			MonthlyLCAGraph();
			loadMallref();
			loadWingref();
			loadFloorref();
			loadClassificationref();
			loadDepartmentref();
			loadCategoryref();
        <?php } ?>
		$("#txtDashboardInquirySearchKey").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				viewInquiryListToday(); 
			}else if(x == '8'){
                if($('#txtDashboardInquirySearchKey').val() == ""){
                    viewInquiryListToday();
                }
            }
		});
		$("#txtDashboardUnitSearchKey").keyup(function(e){
			var type = $("#txtDashboardTypeSearchKey").val();
			var x = event.keyCode;
			if(x == 13){ 
				viewDashbboardUnits(type); 
			}else if(x == '8'){
                if($('#txtDashboardUnitSearchKey').val() == ""){
                    viewDashbboardUnits(type);
                }
            }
		});
		$("#txtDashboardMainExpSearchKey").keyup(function(e){
			var panel = $("#txtDashboardMainExpSearchPanel").val();
			var x = event.keyCode;
			if(x == 13){ 
				ViewDashbboardMaintenance(panel); 
			}else if(x == '8'){
                if($('#txtDashboardMainExpSearchKey').val() == ""){
                    ViewDashbboardMaintenance(panel);
                }
            }
		});
	})

	function SelectDashboardPage(page){
		if(page == 1){
			setTimeout(function(){
        		<?php if($st['softwaretype'] == 0){ ?>
					ShowPanelValPage1();
					showdashapprovalpending();
					MonthlyTotalSalesFromTenantsGraph();
					ShowListOfTopTenants();
					MonthlyOccupancyReportGraph();
					OccpancyBasedonClassificationGraph();
					VacancyBasedonClassificationGraph();
					MonthlyTotalRevenueFromLeaseGraph();
					MonthlySetGraph();
					MonthlyLCAGraph();
					loadMallref();
					loadWingref();
					loadFloorref();
					loadClassificationref();
					loadDepartmentref();
					loadCategoryref();
		        <?php }else if($st['softwaretype'] == 1){ ?>
		        	ShowPanelValPage1();
		        	showdashapprovalpending();
					MonthlyOccupancyReportGraph();
					OccpancyBasedonClassificationGraph();
					VacancyBasedonClassificationGraph();
					MonthlyTotalRevenueFromLeaseGraph();
					MonthlySetGraph();
					MonthlyLCAGraph();
					loadMallref();
					loadWingref();
					loadFloorref();
					loadClassificationref();
					loadDepartmentref();
					loadCategoryref();
		        <?php }else if($st['softwaretype'] == 2){ ?>	
		        	ShowPanelValPage2();
					MonthlyAverageTurnAroundTimeWOGraph();
					MonthlyAverageTurnAroundTimeComplaintsGraph();
					MonthlyAverageTurnAroundTimeIRGraph();
					ShowWorkOrderLogs();
					MonthlyWorkOrdersGraph();
					MonthlyComplaintsGraph();
					MonthlyIncidentReportsGraph();
					MaintenanceBudgetGraph();
					MonthlyConsumptionofElectricReportGraph();
					MonthlyConsumptionofWaterReportGraph();
					MonthlyThirdPartyContractorsGraph();
		        <?php }else if($st['softwaretype'] == 3){ ?>
		        	ShowPanelValPage1();
		        	showdashapprovalpending();
					MonthlyOccupancyReportGraph();
					OccpancyBasedonClassificationGraph();
					VacancyBasedonClassificationGraph();
					MonthlyTotalRevenueFromLeaseGraph();
					MonthlySetGraph();
					MonthlyLCAGraph();
					loadMallref();
					loadWingref();
					loadFloorref();
					loadClassificationref();
					loadDepartmentref();
					loadCategoryref();
		        <?php }else if($st['softwaretype'] == 4){ ?>
		        	ShowPanelValPage1();
		        	showdashapprovalpending();
					MonthlyOccupancyReportGraph();
					OccpancyBasedonClassificationGraph();
					VacancyBasedonClassificationGraph();
					MonthlyTotalRevenueFromLeaseGraph();
					MonthlySetGraph();
					MonthlyLCAGraph();
					loadMallref();
					loadWingref();
					loadFloorref();
					loadClassificationref();
					loadDepartmentref();
					loadCategoryref();
		        <?php }else if($st['softwaretype'] == 5){ ?>
		        	ShowPanelValPage1();
		        	showdashapprovalpending();
					MonthlyOccupancyReportGraph();
					OccpancyBasedonClassificationGraph();
					VacancyBasedonClassificationGraph();
					MonthlyTotalRevenueFromLeaseGraph();
					MonthlySetGraph();
					MonthlyLCAGraph();
					loadMallref();
					loadWingref();
					loadFloorref();
					loadClassificationref();
					loadDepartmentref();
					loadCategoryref();
		        <?php }else{ ?>
		        	ShowPanelValPage1();
		        	showdashapprovalpending();
					MonthlyTotalSalesFromTenantsGraph();
					ShowListOfTopTenants();
					MonthlyOccupancyReportGraph();
					OccpancyBasedonClassificationGraph();
					VacancyBasedonClassificationGraph();
					MonthlyTotalRevenueFromLeaseGraph();
					MonthlySetGraph();
					MonthlyLCAGraph();
					loadMallref();
					loadWingref();
					loadFloorref();
					loadClassificationref();
					loadDepartmentref();
					loadCategoryref();
		        <?php } ?>
			}, 1000)
			$("#DashboardPage1").css("display","block");
			$("#DashboardPage2").css("display","none");
		}else if(page == 2){
			setTimeout(function(){
				<?php if($st['softwaretype'] == 0){ ?>
					ShowPanelValPage2();
					MonthlyAverageTurnAroundTimeWOGraph();
					MonthlyAverageTurnAroundTimeComplaintsGraph();
					MonthlyAverageTurnAroundTimeIRGraph();
					ShowWorkOrderLogs();
					MonthlyWorkOrdersGraph();
					MonthlyComplaintsGraph();
					MonthlyIncidentReportsGraph();
					MaintenanceBudgetGraph();
					MonthlyConsumptionofElectricReportGraph();
					MonthlyConsumptionofWaterReportGraph();
					MonthlyThirdPartyContractorsGraph();
		        <?php }else if($st['softwaretype'] == 1){ ?>
		        	ShowPanelValPage2();
					MonthlyAverageTurnAroundTimeWOGraph();
					MonthlyAverageTurnAroundTimeComplaintsGraph();
					MonthlyAverageTurnAroundTimeIRGraph();
					ShowWorkOrderLogs();
					MonthlyWorkOrdersGraph();
					MonthlyComplaintsGraph();
					MonthlyIncidentReportsGraph();
					MaintenanceBudgetGraph();
					MonthlyConsumptionofElectricReportGraph();
					MonthlyConsumptionofWaterReportGraph();
					MonthlyThirdPartyContractorsGraph();
		        <?php }else if($st['softwaretype'] == 2){ ?>	
		        	ShowPanelValPage1();
					MonthlyOccupancyReportGraph();
					OccpancyBasedonClassificationGraph();
					VacancyBasedonClassificationGraph();
					MonthlyTotalRevenueFromLeaseGraph();
					MonthlySetGraph();
					MonthlyLCAGraph();
					loadMallref();
					loadWingref();
					loadFloorref();
					loadClassificationref();
					loadDepartmentref();
					loadCategoryref();
		        <?php }else if($st['softwaretype'] == 3){ ?>
		        	ShowPanelValPage2();
					MonthlyAverageTurnAroundTimeWOGraph();
					MonthlyAverageTurnAroundTimeComplaintsGraph();
					MonthlyAverageTurnAroundTimeIRGraph();
					ShowWorkOrderLogs();
					MonthlyWorkOrdersGraph();
					MonthlyComplaintsGraph();
					MonthlyIncidentReportsGraph();
					MaintenanceBudgetGraph();
					MonthlyConsumptionofElectricReportGraph();
					MonthlyConsumptionofWaterReportGraph();
					MonthlyThirdPartyContractorsGraph();
		        <?php }else if($st['softwaretype'] == 4){ ?>
		        	ShowPanelValPage2();
					MonthlyAverageTurnAroundTimeWOGraph();
					MonthlyAverageTurnAroundTimeComplaintsGraph();
					MonthlyAverageTurnAroundTimeIRGraph();
					ShowWorkOrderLogs();
					MonthlyWorkOrdersGraph();
					MonthlyComplaintsGraph();
					MonthlyIncidentReportsGraph();
					MaintenanceBudgetGraph();
					MonthlyConsumptionofElectricReportGraph();
					MonthlyConsumptionofWaterReportGraph();
					MonthlyThirdPartyContractorsGraph();
		        <?php }else if($st['softwaretype'] == 5){ ?>
		        	ShowPanelValPage2();
					MonthlyAverageTurnAroundTimeWOGraph();
					MonthlyAverageTurnAroundTimeComplaintsGraph();
					MonthlyAverageTurnAroundTimeIRGraph();
					ShowWorkOrderLogs();
					MonthlyWorkOrdersGraph();
					MonthlyComplaintsGraph();
					MonthlyIncidentReportsGraph();
					MaintenanceBudgetGraph();
					MonthlyConsumptionofElectricReportGraph();
					MonthlyConsumptionofWaterReportGraph();
					MonthlyThirdPartyContractorsGraph();
		        <?php }else{ ?>
		        	ShowPanelValPage1();
					MonthlyTotalSalesFromTenantsGraph();
					ShowListOfTopTenants();
					MonthlyOccupancyReportGraph();
					OccpancyBasedonClassificationGraph();
					VacancyBasedonClassificationGraph();
					MonthlyTotalRevenueFromLeaseGraph();
					MonthlySetGraph();
					MonthlyLCAGraph();
					loadMallref();
					loadWingref();
					loadFloorref();
					loadClassificationref();
					loadDepartmentref();
					loadCategoryref();
		        <?php } ?>
			}, 1000)
			$("#DashboardPage1").css("display","none");
			$("#DashboardPage2").css("display","block");
		}
	}


// START OF PAGE 1
	function ShowPanelValPage1(){
		$.ajax({
			type: 'POST',
			url: 'dashboard/class.php',
			data: 'form=ShowPanelValPage1',
			success:function(data){
				var arr = data.split("|");
				$("#txtInqToday").text(arr[0]);
				$("#txtUnitTotal").text(arr[1]);
				$("#txtUnitOccupied").text(arr[2]);
				$("#txtUnitAvailable").text(arr[3]);
			}
		})
	}

	function viewInquiryListToday(){
		$("#dashboard_Viewdetails").modal("show");
		var key = $("#txtDashboardInquirySearchKey").val();
		$.ajax({
			type: 'POST',
			url: 'dashboard/class.php',
			data: 'key=' + key + '&form=viewInquiryListToday',
			beforeSend : function() {
		       	$('#pre_tblDashboardListofInquiry').addClass('myspinner');
		    },
			success: function(data){
				$('#pre_tblDashboardListofInquiry').removeClass('myspinner');
        		if(data != ""){
		          	$("#tblDashboardListofInquiry").html(data);
		        }else{
		          	$("#tblDashboardListofInquiry").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
		        }
			}
		})
	}

	function viewDashbboardUnits(type){
		$("#txtDashboardTypeSearchKey").val(type);
		var key = $("#txtDashboardUnitSearchKey").val();
		var Mall = $("#txtDashMall").val();
		var Wing = $("#txtDashWing").val();
		var Floor = $("#txtDashFloor").val();
		var Classification = $("#txtDashClassification").val();
		var Department = $("#txtDashDepartment").val();
		var Category = $("#txtDashCategory").val();
		// $("#txtDashMall").attr("onchange", "viewDashbboardUnits(\""+type+"\")");
		// $("#txtDashWing").attr("onchange", "viewDashbboardUnits(\""+type+"\")");
		// $("#txtDashFloor").attr("onchange", "viewDashbboardUnits(\""+type+"\")");
		// $("#txtDashClassification").attr("onchange", "viewDashbboardUnits(\""+type+"\")");
		// $("#txtDashDepartment").attr("onchange", "viewDashbboardUnits(\""+type+"\")");
		// $("#txtDashCategory").attr("onchange", "viewDashbboardUnits(\""+type+"\")");
		if(type == "Vacant"){
			$("#txtDashboardUnitHeader").text("List of Available Units");
			$("#dashboard_ViewdetailsUnit").modal("show");
			$("#isVacant").css("display", "table-row");
			$("#isNotVacant").css("display", "none");
		}else if(type == "Reserved"){
			$("#txtDashboardUnitHeader").text("List of Reserved Units");
			$("#dashboard_ViewdetailsUnit").modal("show");
			$("#isVacant").css("display", "none");
			$("#isNotVacant").css("display", "table-row");
			$("#tdDashboardDateInput").text("Reservation Date");
		}else if(type == "Occupied"){
			$("#txtDashboardUnitHeader").text("List of Occupied Units");
			$("#dashboard_ViewdetailsUnit").modal("show");
			$("#isVacant").css("display", "none");
			$("#isNotVacant").css("display", "table-row");
			$("#tdDashboardDateInput").text("Occupancy Period");
		}
		$.ajax({
			type: 'POST',
			url: 'dashboard/class.php',
			data: 'key=' + key + '&type=' + type + '&Mall=' + Mall + '&Wing=' + Wing + '&Floor=' + Floor + '&Classification=' + Classification + '&Department=' + Department + '&Category=' + Category + '&form=viewDashbboardUnits',
			beforeSend : function() {
		       	$('#pre_tblDashboardListofUnits').addClass('myspinner');
		    },
			success: function(data){
				$('#pre_tblDashboardListofUnits').removeClass('myspinner');
        		if(data != ""){
		          	$("#tblDashboardListofUnits").html(data);
		        }else{
		          	$("#tblDashboardListofUnits").html("<tr><td colspan='7' style='text-align: center;'>No Data Found...</td></tr>");
		        }
			}
		})
	}

	function loadMallref(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success:function(data){
				$("#txtDashMall").html(data);
			}
		})
	}

	function loadWingref(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_wing',
			success:function(data){
				$("#txtDashWing").html(data);
			}
		})
	}

	function loadFloorref(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_floor',
			success:function(data){
				$("#txtDashFloor").html(data);
			}
		})
	}

	function loadClassificationref(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_merchandise_class',
			success:function(data){
				$("#txtDashClassification").html(data);
			}
		})
	}

	function loadDepartmentref(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_merchandise_depa',
			success:function(data){
				$("#txtDashDepartment").html(data);
			}
		})
	}

	function loadCategoryref(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_merchandisedep_cat',
			success:function(data){
				$("#txtDashCategory").html(data);
			}
		})
	}

	function XUnitModal(){
		$("#txtDashMall").val("");
		$("#txtDashWing").val("");
		$("#txtDashFloor").val("");
		$("#txtDashClassification").val("");
		$("#txtDashDepartment").val("");
		$("#txtDashCategory").val("");
		$("#txtDashboardUnitSearchKey").val("");
		$("#txtDashboardTypeSearchKey").val("");
		$("#dashboard_ViewdetailsUnit").modal("hide");
	}

	// MONTHLY TOTAL SALES FROM TENANTS
	function MonthlyTotalSalesFromTenants(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyTotalSalesFromTenants',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyTotalSalesFromTenantsGraph(){
		var fncSales = JSON.parse(MonthlyTotalSalesFromTenants());
		Highcharts.chart('div_MonthlyTotalSalesFromTenants', {
		    chart: {
		        type: 'line',
		        height: 400
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		    yAxis: [{
		        title: {
		            text: 'Total Sales of Tenants'
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: 'Total Sales Of Tenants'
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		}
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
		        valueDecimals: 2,
        		valuePrefix: 'P',		    
        	},
		    series:  [{
				        name: 'Total Sales Of Tenants',
				        data: fncSales,
						color: '#008000'
				    }]
		});
	}

	function ShowTenantSalesGraph(){
		setTimeout(function(){
			MonthlyTotalSalesFromTenantsGraph();
		}, 1000)
	}

	function ShowTenantSalesTable(){
		$.ajax({
			type: 'POST',
			url: 'dashboard/class.php',
			data: 'form=ShowTenantSalesTable',
			success:function(data){
				$("#div_MonthlyTotalSalesFromTenants").html(data);
    			$(".fixTable").tableHeadFixer(); 
			}
		})
	}

	// TOP LIST OF TENANTS BASED ON SALES
	function ShowListOfTopTenants(){
		$.ajax({
			type: 'POST',
			url: 'dashboard/class.php',
			data: 'form=ShowListOfTopTenants',
			success:function(data){
				$("#div_ListOfTopTenants").html(data);
			}
		})
	}

	//Monthly OCCUPANCY REPORT
	function MonthlyOccupancyReport(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyOccupancyReport',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyOccupancyReportGraph(){
		var fncMonthlyOccupancyReport = JSON.parse(MonthlyOccupancyReport());
		Highcharts.chart('div_MonthlyOccupancyReport', {
		    chart: {
		        type: 'line',
		        height: 400
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		    yAxis: [{
		        title: {
		            text: 'Number of Units'
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: 'Number of Units'
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		}
		    },
		    // exporting: {
		    //     buttons: {
		    //         customButton: {
		    //             text: 'Custom Button',
		    //             onclick: function () {
		    //                 alert('You pressed the button!');
		    //             }
		    //         },
		    //        anotherButton: {
		    //             text: 'Another Button',
		    //             onclick: function () {
		    //                 alert('You pressed another button!');
		    //             }
		    //         }
		    //     }
		    // },
		    tooltip: {
		        // headerFormat: '<span style="font-size: 18px;">{series.name}</span><br>',
        		// pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
        		valueSuffix: ' Unit(s)',
        		split: true
		    },
		    series: fncMonthlyOccupancyReport
		});
	}

	// OCCUPANCY BASED ON CLASSIFICATION
	function OccpancyBasedonClassification(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=OccpancyBasedonClassification',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function OccpancyBasedonClassificationGraph(){
		var fncOccupied = JSON.parse(OccpancyBasedonClassification());
		Highcharts.chart('div_OccupancyBasedonClassification', {
		    chart: {
		        type: 'pie',
		        height: 166
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				type: 'category'
		    },
		     yAxis: [{
		        title: {
		            text: ''
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: ''
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		},
        		pie: {
        			allowPointSelect: true,
        			cursor: 'pointer',
        			showInLegend: true,
        			dataLabels: {
          				enabled: false,
          				format: '{point.y:,.0f}'
        			}
      			}
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
        		valueSuffix: ' Unit(s)',
        	},
		    series:  [{
				        name: 'Occupied',
				        data: fncOccupied
				    }]
		});
	}

	// VACANT BASED ON CLASSIFICATION
	function VacancyBasedonClassification(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=VacancyBasedonClassification',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function VacancyBasedonClassificationGraph(){
		var fncVacant = JSON.parse(VacancyBasedonClassification());
		Highcharts.chart('div_VacancyBasedonClassification', {
		    chart: {
		        type: 'pie',
		        height: 166
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				type: 'category'
		    },
		     yAxis: [{
		        title: {
		            text: ''
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: ''
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		},
        		pie: {
        			allowPointSelect: true,
        			cursor: 'pointer',
        			showInLegend: true,
        			dataLabels: {
          				enabled: false,
          				format: '{point.y:,.0f}'
        			}
      			}
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
        		valueSuffix: ' Unit(s)',
        	},
		    series:  [{
				        name: 'Vacant',
				        data: fncVacant
				    }]
		});
	}

	// MONTHLY TOTAL SALES FROM LEASE
	function MonthlyTotalRevenueFromLease(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyTotalRevenueFromLease',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyTotalRevenueFromLeaseGraph(){
		var fncLease = JSON.parse(MonthlyTotalRevenueFromLease());
		Highcharts.chart('div_MonthlyTotalRevenueFromLease', {
		    chart: {
		        type: 'line'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		     yAxis: [{
		        title: {
		            text: 'Total Revenue From Lease'
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: 'Total Revenue From Lease'
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		}
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
		        valueDecimals: 2,
        		valuePrefix: 'P',		    
        	},
		    series:  [{
				        name: 'Total Revenue From Lease',
				        data: fncLease,
				        color: 'red'
				    }]
		});
	}

	//Monthly SET VACANT
	function MonthlySet(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlySet',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlySetGraph(){
		var fncMonthlySET = JSON.parse(MonthlySet());
		Highcharts.chart('div_MonthlySET', {
		    chart: {
		        type: 'column'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		    yAxis: [{
		        title: {
		            text: 'Number of SET Units'
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: 'Number of SET Units'
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		}
		    },
		    tooltip: {
		    	formatter: function () {
		            return '<span style="font-size: 18px;">'+this.series.name+'</span><br/>'+
		                '<span style="font-size: 18px;">'+this.x+': </span><b>' + this.y + ' Unit(s)</b>';
		        },
		        // headerFormat: '<span style="font-size: 18px;">'+this.category+'</span><br>',
        		// pointFormat: '<span style="font-size: 18px;">{series.name}</span>: <b>{point.y}</b>',
		    },
		    series: fncMonthlySET
		});
	}

	//Monthly LCA VACANT
	function MonthlyLCA(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyLCA',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyLCAGraph(){
		var fncMonthlyLCA = JSON.parse(MonthlyLCA());
		Highcharts.chart('div_MonthlyLCA', {
		    chart: {
		        type: 'column'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		    yAxis: [{
		        title: {
		            text: 'Number of LCA Units'
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: 'Number of LCA Units'
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		}
		    },
		   	tooltip: {
		    	formatter: function () {
		            return '<span style="font-size: 18px;">'+this.series.name+'</span><br/>'+
		                '<span style="font-size: 18px;">'+this.x+': </span><b>' + this.y + ' Unit(s)</b>';
		        },
		        // headerFormat: '<span style="font-size: 18px;">'+this.category+'</span><br>',
        		// pointFormat: '<span style="font-size: 18px;">{series.name}</span>: <b>{point.y}</b>',
		    },
		    series: fncMonthlyLCA
		});
	}
// END OF PAGE 1
	
// START OF PAGE 2
	function ShowPanelValPage2(){
		$.ajax({
			type: 'POST',
			url: 'dashboard/class.php',
			data: 'form=ShowPanelValPage2',
			success:function(data){
				var arr = data.split("|");
				$("#txtNewWO").text(arr[0]);
				$("#txtNewComplaints").text(arr[1]);
				$("#txtNewIR").text(arr[2]);
				$("#txtTotalMaintenanceExpense").text(arr[3]);
			}
		})
	}

	function ViewDashbboardMaintenance(panel){
		$("#txtDashboardMainExpSearchPanel").val(panel);
		var key = $("#txtDashboardMainExpSearchKey").val();
		if(panel == "MainExp"){
			$("#trMainExp").css("display", "table-row");
			$("#trIncidentReports").css("display", "none");
			$("#trComplaints").css("display", "none");
			$("#trWorkOrders").css("display", "none");
			$("#dashboard_ViewdetailsMaintenanceTitle").text("List of Maintenance Expense");
			$("#txtDashboardMainExpSearchKey").attr("placeholder", "Search Maintenance Expense");
			$.ajax({
				type: 'POST',
				url: 'dashboard/class.php',
				data: 'key=' + key + '&form=ViewMaintenanceExp',
				beforeSend : function() {
			       	$('#pre_tblDashboardMaintenance').addClass('myspinner');
		    	},
				success:function(data){
					$('#pre_tblDashboardMaintenance').removeClass('myspinner');
					if(data != ""){
			          	$("#tblDashboardListofMain").html(data);
			        }else{
			          	$("#tblDashboardListofMain").html("<tr><td colspan='5' style='text-align: center;'>No Data Found...</td></tr>");
			        }
					$("#dashboard_ViewdetailsMaintenance").modal("show");
				}
			})	
		}else if(panel == "IncidentReports"){
			$("#trMainExp").css("display", "none");
			$("#trIncidentReports").css("display", "table-row");
			$("#trComplaints").css("display", "none");
			$("#trWorkOrders").css("display", "none");
			$("#dashboard_ViewdetailsMaintenanceTitle").text("List of Pending Incident Reports");
			$("#txtDashboardMainExpSearchKey").attr("placeholder", "Search Incident Reports");
			$.ajax({
				type: 'POST',
				url: 'dashboard/class.php',
				data: 'key=' + key + '&form=ViewMaintenanceIR',
				beforeSend : function() {
			       	$('#pre_tblDashboardMaintenance').addClass('myspinner');
		    	},
				success:function(data){
					$('#pre_tblDashboardMaintenance').removeClass('myspinner');
					if(data != ""){
			          	$("#tblDashboardListofMain").html(data);
			        }else{
			          	$("#tblDashboardListofMain").html("<tr><td colspan='3' style='text-align: center;'>No Data Found...</td></tr>");
			        }
					$("#dashboard_ViewdetailsMaintenance").modal("show");
				}
			})	
		}else if(panel == "Complaints"){
			$("#trMainExp").css("display", "none");
			$("#trIncidentReports").css("display", "none");
			$("#trComplaints").css("display", "table-row");
			$("#trWorkOrders").css("display", "none");
			$("#dashboard_ViewdetailsMaintenanceTitle").text("List of Pending Complaints");
			$("#txtDashboardMainExpSearchKey").attr("placeholder", "Search Complaints");
			$.ajax({
				type: 'POST',
				url: 'dashboard/class.php',
				data: 'key=' + key + '&form=ViewMaintenanceComplaints',
				beforeSend : function() {
			       	$('#pre_tblDashboardMaintenance').addClass('myspinner');
		    	},
				success:function(data){
					$('#pre_tblDashboardMaintenance').removeClass('myspinner');
					if(data != ""){
			          	$("#tblDashboardListofMain").html(data);
			        }else{
			          	$("#tblDashboardListofMain").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
			        }
					$("#dashboard_ViewdetailsMaintenance").modal("show");
				}
			})	
		}else if(panel == "WorkOrders"){
			$("#trMainExp").css("display", "none");
			$("#trIncidentReports").css("display", "none");
			$("#trComplaints").css("display", "none");
			$("#trWorkOrders").css("display", "table-row");
			$("#dashboard_ViewdetailsMaintenanceTitle").text("List of Work Orders");
			$("#txtDashboardMainExpSearchKey").attr("placeholder", "Search Work Orders");
			$.ajax({
				type: 'POST',
				url: 'dashboard/class.php',
				data: 'key=' + key + '&form=ViewMaintenanceWorkOrders',
				beforeSend : function() {
			       	$('#pre_tblDashboardMaintenance').addClass('myspinner');
		    	},
				success:function(data){
					$('#pre_tblDashboardMaintenance').removeClass('myspinner');
					if(data != ""){
			          	$("#tblDashboardListofMain").html(data);
			        }else{
			          	$("#tblDashboardListofMain").html("<tr><td colspan='4' style='text-align: center;'>No Data Found...</td></tr>");
			        }
					$("#dashboard_ViewdetailsMaintenance").modal("show");
				}
			})
		}
	}

	// MONTHLY TURN AROUND TIME BY DATE
	function MonthlyAverageTurnAroundTimeWO(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyAverageTurnAroundTimeWO',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyAverageTurnAroundTimeWOGraph(){
		var fncMonthlyATAT = JSON.parse(MonthlyAverageTurnAroundTimeWO());
		Highcharts.chart('div_MonthlyATATWO', {
		    chart: {
		        type: 'column'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		     yAxis: [{
		        title: {
		            text: ''
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: ''
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		},
        		pie: {
        			allowPointSelect: true,
        			cursor: 'pointer',
        			showInLegend: true,
        			dataLabels: {
          				enabled: false,
          				format: '{point.y:,.0f}'
        			}
      			}
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
        		valueSuffix: ' Day(s)',
        	},
		    series:  [{
				        name: 'Average TAT of Work Orders (Days)',
				        data: fncMonthlyATAT,
				        color: 'blue'
				    }]
		});
	}

	// MONTHLY TURN AROUND TIME BY DATE
	function MonthlyAverageTurnAroundTimeComplaints(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyAverageTurnAroundTimeComplaints',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyAverageTurnAroundTimeComplaintsGraph(){
		var fncMonthlyATAT = JSON.parse(MonthlyAverageTurnAroundTimeComplaints());
		Highcharts.chart('div_MonthlyATATComplaints', {
		    chart: {
		        type: 'column'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		     yAxis: [{
		        title: {
		            text: ''
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: ''
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		},
        		pie: {
        			allowPointSelect: true,
        			cursor: 'pointer',
        			showInLegend: true,
        			dataLabels: {
          				enabled: false,
          				format: '{point.y:,.0f}'
        			}
      			}
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
        		valueSuffix: ' Day(s)',
        	},
		    series:  [{
				        name: 'Average TAT of Complaints (Days)',
				        data: fncMonthlyATAT,
				        color: 'red'
				    }]
		});
	}

	// MONTHLY TURN AROUND TIME BY DATE
	function MonthlyAverageTurnAroundTimeIR(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyAverageTurnAroundTimeIR',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyAverageTurnAroundTimeIRGraph(){
		var fncMonthlyATAT = JSON.parse(MonthlyAverageTurnAroundTimeIR());
		Highcharts.chart('div_MonthlyATATIR', {
		    chart: {
		        type: 'column'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		     yAxis: [{
		        title: {
		            text: ''
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: ''
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		},
        		pie: {
        			allowPointSelect: true,
        			cursor: 'pointer',
        			showInLegend: true,
        			dataLabels: {
          				enabled: false,
          				format: '{point.y:,.0f}'
        			}
      			}
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
        		valueSuffix: ' Day(s)',
        	},
		    series:  [{
				        name: 'Average TAT of Incident Reports (Days)',
				        data: fncMonthlyATAT,
				        color: 'orange'
				    }]
		});
	}

	// WORK ORDER LOGS
	function ShowWorkOrderLogs(){
		$.ajax({
			type: 'POST',
			url: 'dashboard/class.php',
			data: 'form=ShowWorkOrderLogs',
			success:function(data){
				$("#div_WorkOrderLogs").html(data);
			}
		})
	}

	// MONTHLY WORK ORDERS PENDING
	function MonthlyWorkOrdersPending(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyWorkOrdersPending',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	// MONTHLY WORK ORDERS RESOLVED
	function MonthlyWorkOrdersResolved(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyWorkOrdersResolved',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyWorkOrdersGraph(){
		var fncMonthlyWorkOrdersPending = JSON.parse(MonthlyWorkOrdersPending());
		var fncMonthlyWorkOrdersResolved = JSON.parse(MonthlyWorkOrdersResolved());
		Highcharts.chart('div_MonthlyWorkOrders', {
		    chart: {
		        type: 'column'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		     yAxis: [{
		        title: {
		            text: ''
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: ''
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		},
        		pie: {
        			allowPointSelect: true,
        			cursor: 'pointer',
        			showInLegend: true,
        			dataLabels: {
          				enabled: false,
          				format: '{point.y:,.0f}'
        			}
      			}
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
        		valueSuffix: ' Work Order(s)',
        	},
		    series: [{
				    	name: 'Pending',
				    	data: fncMonthlyWorkOrdersPending,
				    	color: 'orange'
			    	},{
			    		name: 'Resolved',
			    		data: fncMonthlyWorkOrdersResolved,
				    	color: 'green'
			    	}]
		});
	}

	// MONTHLY COMPLAINTS PENDING
	function MonthlyComplaintsPending(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyComplaintsPending',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	// MONTHLY COMPLAINTS RESOLVED
	function MonthlyComplaintsResolved(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyComplaintsResolved',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyComplaintsGraph(){
		var fncMonthlyComplaintsPending = JSON.parse(MonthlyComplaintsPending());
		var fncMonthlyComplaintsResolved = JSON.parse(MonthlyComplaintsResolved());
		Highcharts.chart('div_MonthlyComplaints', {
		    chart: {
		        type: 'column'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		     yAxis: [{
		        title: {
		            text: ''
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: ''
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		},
        		pie: {
        			allowPointSelect: true,
        			cursor: 'pointer',
        			showInLegend: true,
        			dataLabels: {
          				enabled: false,
          				format: '{point.y:,.0f}'
        			}
      			}
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
        		valueSuffix: ' Complaint(s)',
        	},
		    series: [{
				    	name: 'Pending',
				    	data: fncMonthlyComplaintsPending,
				    	color: 'orange'
			    	},{
			    		name: 'Resolved',
			    		data: fncMonthlyComplaintsResolved,
				    	color: 'green'
			    	}]
		});
	}

	// MONTHLY INCIDENT REPORTS BASED ON STATUS PENDING
	function MonthlyIncidentReportsPending(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyIncidentReportsPending',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	// MONTHLY INCIDENT REPORTS BASED ON STATUS RESOLVED
	function MonthlyIncidentReportsResolved(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyIncidentReportsResolved',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyIncidentReportsGraph(){
		var fncPending = JSON.parse(MonthlyIncidentReportsPending());
		var fncResolved = JSON.parse(MonthlyIncidentReportsResolved());
		Highcharts.chart('div_MonthlyIncidentReports', {
		    chart: {
		        type: 'column'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		     yAxis: [{
		        title: {
		            text: ''
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: ''
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		},
        		pie: {
        			allowPointSelect: true,
        			cursor: 'pointer',
        			showInLegend: true,
        			dataLabels: {
          				enabled: false,
          				format: '{point.y:,.0f}'
        			}
      			}
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
        		valueSuffix: ' Incident Report(s)',
        	},
		    series:  [{
				        name: 'Pending',
				        data: fncPending,
				        color: 'orange'
				    },{
				        name: 'Resolved',
				        data: fncResolved,
				        color: 'green'
				    }]
		});
	}

	// PREVIOUS BUDGET
	function MaintenanceBudgetPrev(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MaintenanceBudgetPrev',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	// CURRENT BUDGET
	function MaintenanceBudgetCurr(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MaintenanceBudgetCurr',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	// DRILLDOWN OF BUDGET
	function MaintenanceBudgetPrevDD(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MaintenanceBudgetPrevDD',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MaintenanceBudgetGraph(){
		var fncMainBudgetPrev = JSON.parse(MaintenanceBudgetPrev());
		var fncMainBudgetCurr = JSON.parse(MaintenanceBudgetCurr());
		var DDPrev = JSON.parse(MaintenanceBudgetPrevDD());
		Highcharts.chart('div_BudgetvsExpense', {
		    chart: {
		        type: 'column'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				type: 'category'
		    },
		    yAxis: [{
		        min: 0,
		        title: {
		            text: ''
		        }
		    }, {
		        title: {
		            text: ''
		        },
		        opposite: true
		    }],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
		            shadow: false,
		            borderWidth: 0,
            		borderRadius: 5
        		}
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
        		valueDecimals: 2,
        		valuePrefix: 'P'
        	},
		    series:  [{
				    	name: '<?php echo date('Y', strtotime('-1 year')); ?>',
				    	data: fncMainBudgetPrev,
				    	color: 'red'
			    	},{
			    		name: '<?php echo date('Y'); ?>',
			    		data: fncMainBudgetCurr,
				    	color: 'blue'
			    	}],
            drilldown: {
                series: DDPrev
		        }
			});
	}

	// MONTHLY CONSUMPTION OF ELECTRIC REPORT PREVIOUS
	function MonthlyConsumptionofElectricReportPrevious(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyConsumptionofElectricReportPrevious',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	// MONTHLY CONSUMPTION OF ELECTRIC REPORT CURRENT
	function MonthlyConsumptionofElectricReportCurrent(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyConsumptionofElectricReportCurrent',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyConsumptionofElectricReportGraph(){
		var fncPrevious = JSON.parse(MonthlyConsumptionofElectricReportPrevious());
		var fncCurrent = JSON.parse(MonthlyConsumptionofElectricReportCurrent());
		Highcharts.chart('div_MonthlyConsumptionofElectricReport', {
		    chart: {
		        type: 'line'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		    yAxis: [{
		        title: {
		            text: ''
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: ''
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		},
        		pie: {
        			allowPointSelect: true,
        			cursor: 'pointer',
        			showInLegend: true,
        			dataLabels: {
          				enabled: false,
          				format: '{point.y:,.0f}'
        			}
      			}
		    },
		    tooltip: {
		        // headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		// pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
        		valueSuffix: ' kWh',
        		split: true
        	},
		    series:  [{
				        name: '<?php echo date('Y', strtotime('-1 year')); ?>',
				        data: fncPrevious,
				        color: 'red'
				    },{
				        name: '<?php echo date('Y'); ?>',
				        data: fncCurrent,
				        color: 'yellow'
				    }]
		});
	}

	// MONTHLY CONSUMPTION OF WATER REPORT PREVIOUS
	function MonthlyConsumptionofWaterReportPrevious(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyConsumptionofWaterReportPrevious',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	// MONTHLY CONSUMPTION OF WATER REPORT CURRENT
	function MonthlyConsumptionofWaterReportCurrent(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyConsumptionofWaterReportCurrent',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyConsumptionofWaterReportGraph(){
		var fncPrevious = JSON.parse(MonthlyConsumptionofWaterReportPrevious());
		var fncCurrent = JSON.parse(MonthlyConsumptionofWaterReportCurrent());
		Highcharts.chart('div_MonthlyConsumptionofWaterReport', {
		    chart: {
		        type: 'line'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		     yAxis: [{
		        title: {
		            text: ''
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: ''
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		},
        		pie: {
        			allowPointSelect: true,
        			cursor: 'pointer',
        			showInLegend: true,
        			dataLabels: {
          				enabled: false,
          				format: '{point.y:,.0f}'
        			}
      			}
		    },
		    tooltip: {
		        // headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		// pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
        		valueSuffix: ' m3',
        		split: true
        	},
		    series:  [{
				        name: '<?php echo date('Y', strtotime('-1 year')); ?>',
				        data: fncPrevious,
				        color: 'green'
				    },{
				        name: '<?php echo date('Y'); ?>',
				        data: fncCurrent,
				        color: 'blue'
				    }]
		});
	}

	// MONTHLY INCIDENT REPORTS BASED ON STATUS RESOLVED
	function MonthlyThirdPartyContractors(){
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'dashboard/class.php',
			data: 'form=MonthlyThirdPartyContractors',
			success:function(data){
				arr = data;
			}
		})
		return arr;
	}

	function MonthlyThirdPartyContractorsGraph(){
		var fncContractor = JSON.parse(MonthlyThirdPartyContractors());
		Highcharts.chart('div_MonthlyReporsOnThirdPartyContractos', {
		    chart: {
		        type: 'line'
		    },
		    credits: {
				enabled: false
			},
		    title: {
		        text: '' 
		    },
		    xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    },
		     yAxis: [{
		        title: {
		            text: ''
		        }
		    }, {
        		opposite: true,
        		title: {
           	 		text: ''
        		}
    		}],
		    legend: {
		        enabled: true
		    },
		    plotOptions: {
		        series: {
		            borderWidth: 0,
		            dataLabels: {
		                enabled: false
		            }
		        },
		        column: {
            		borderRadius: 5
        		},
        		pie: {
        			allowPointSelect: true,
        			cursor: 'pointer',
        			showInLegend: true,
        			dataLabels: {
          				enabled: false,
          				format: '{point.y:,.0f}'
        			}
      			}
		    },
		    tooltip: {
		        // headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
        		// pointFormat: '<span style="font-size: 18px;"></span><b>{point.y}</b>',
        		valueSuffix: ' Contract(s)',
        		split: true
        	},
		    series:  fncContractor
		});
	}
// END OF PAGE 2
</script>

<!-- Added By KevinL 09-25-2019 -->
<script type="text/javascript">
	function showdashapprovalpending(){
		$.ajax({
			type: 'POST',
			url: 'dashboard/kevdashclass.php',
			data: 'form=showdashapprovalpending',
			success:function(data){
				var arr = data.split("|");
				$("#txtapptenantsrequest").text(arr[0]);
			}
		})
	}


</script>