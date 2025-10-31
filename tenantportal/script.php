<script type="text/javascript">
	$(function(){
		$(".date-picker").datepicker({
			autoHide: true,
			format: 'mm/dd/yyyy',
			todayHighlight: true
		});
		$('.id-input-file').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});
		$('#csvFiles').submit(function () {
			uploadcsvfiles();
			return false;
		});
		$("#tpOldPassword").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				savetenantportalpassword(); 
			}
		});
		$("#tpNewPassword").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				savetenantportalpassword(); 
			}
		});
		$("#tpConfirmNewPassword").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				savetenantportalpassword(); 
			}
		});
		$("#txtSearchTradeTP").keyup(function(e){
			var x = event.keyCode;
			if(x == 13){ 
				tbltptenantlist(); 
			}else if(x == '8'){
				if($('#txtSearchTradeTP').val() == ""){
					tbltptenantlist();
				}
			}
		});
		tbltptenantlist();
		var date = new Date();
		date.setDate(date.getDate() - 0);
		$('.jonas-date-picker').datepicker({
			autoclose: true,
			todayHighlight: true,
			format: 'mm/dd/yyyy',
			startDate: date
		});
		$("#maindiv_FileInputDiscount").each(function(){
			$(this).find("a").attr("onclick", "$('#iValSuccessDiscount').css('display', 'none');$('#iValFailedDiscount').css('display', 'none');");
		});
		$("#maindiv_FileInputHourly").each(function(){
			$(this).find("a").attr("onclick", "$('#iValSuccessHourly').css('display', 'none');$('#iValFailedHourly').css('display', 'none');");
		});
		$("#maindiv_FileInputPayment").each(function(){
			$(this).find("a").attr("onclick", "$('#iValSuccessPayment').css('display', 'none');$('#iValFailedPayment').css('display', 'none');");
		});
		$("#maindiv_FileInputCanceled").each(function(){
			$(this).find("a").attr("onclick", "$('#iValSuccessCancelled').css('display', 'none');$('#iValFailedCancelled').css('display', 'none');");
		});
		$("#maindiv_FileInputSales").each(function(){
			$(this).find("a").attr("onclick", "$('#iValSuccessSales').css('display', 'none');$('#iValFailedSales').css('display', 'none');");
		});
		$("#txtInputDiscountCSV").prop("disabled", true);
		$("#txtInputHourlyCSV").prop("disabled", true);
		$("#txtInputPaymentCSV").prop("disabled", true);
		$("#txtInputRoCCSV").prop("disabled", true);
		$("#txtInputSalesCSV").prop("disabled", true);
		$("#btnUpload").prop("disabled", true);
		$("#txtInputDateCSV").prop("disabled", true);
		$("#tpProfilePicture").attr("src", "assets/images/noimage5.png");

		getDates();
	})

	function loadinfo_old(tenantid){
		$("#TPTenantID").val(tenantid);
		var TargetDate = $("#txtInputDateCSV").val();
		$.ajax({
			type: 'POST',
			url: 'tenantportal/class.php',
			data: 'TenantID=' + tenantid + '&form=TenantInfo',
			success:function(data){
				var arr = data.split("|");
				$("#tpCompanyName").text(arr[0]);
				$("#tpTenantID").text(arr[1]);
				$("#tpMerchantCode").text(arr[2]);
				$("#tpMall").text(arr[3]);
				$("#tpUnitNumber").text(arr[4]);
				$("#tpProfilePicture").attr("alt", arr[0] +"'s Photo");
				$("#tpProfilePicture").attr("src", arr[5]);
			}
		})
		$.ajax({
			type: 'POST',
			url: 'tenantportal/class.php',
			data: 'TenantID=' + tenantid + '&form=showpendingcomplaints',
			success:function(data){
				$("#tpComplaintsCount").text(data);
			}
		})
		$.ajax({
			type: 'POST',
			url: 'tenantportal/class.php',
			data: 'TenantID=' + tenantid + '&form=showpendingworkorder',
			success:function(data){
				$("#tpWorkOrderCount").text(data);
			}
		})
		$.ajax({
			type: 'POST',
			url: 'tenantportal/class.php',
			data: 'TenantID=' + tenantid + '&form=showpenalty',
			success:function(data){
				$("#tpPenaltyCount").text(data);
			}
		})
		$.ajax({
			type: 'POST',
			url: 'tenantportal/class.php',
			data: 'TargetDate=' + TargetDate + '&TenantID=' + tenantid + '&form=DisableFields',
			success:function(data){
				var arr = data.split("|");
				if(arr[0] == 1){
					$("#txtInputDiscountCSV").prop("disabled", true);
				}else{
					$("#txtInputDiscountCSV").prop("disabled", false);
				}
				if(arr[1] == 1){
					$("#txtInputHourlyCSV").prop("disabled", true);
				}else{
					$("#txtInputHourlyCSV").prop("disabled", false);
				}
				if(arr[2] == 1){
					$("#txtInputPaymentCSV").prop("disabled", true);
				}else{
					$("#txtInputPaymentCSV").prop("disabled", false);
				}
				if(arr[3] == 1){
					$("#txtInputRoCCSV").prop("disabled", true);
				}else{
					$("#txtInputRoCCSV").prop("disabled", false);
				}
				if(arr[4] == 1){
					$("#txtInputSalesCSV").prop("disabled", true);
				}else{
					$("#txtInputSalesCSV").prop("disabled", false);
				}
				if(arr[0] == 1 && arr[1] == 1 && arr[2] == 1 && arr[3] == 1 && arr[4] == 1){
					$("#btnUpload").prop("disabled", true);
				}else{
					$("#btnUpload").prop("disabled", false);
				}
			}
		})
		$("#txtInputDateCSV").prop("disabled", false);
		showgraph();
		csvfolders();
	}

	function ilbethetrigger(){
		setTimeout(function(){
			showgraph();
		}, 1000)
	}

	function checkfiletype(fileName, id, CSVType){
		var fileExtension = "";
		fileExtension = fileName.substr((fileName.lastIndexOf('.') + 1));
		if(fileExtension != "csv" && fileExtension != "CSV"){
			$("#"+id).val("");
			showmodal("alert", "Invalid file type.", "", null, "", null, "0");
		}else{
			if(CSVType == "Discount"){
				ValidateDiscount();
			}else if(CSVType == "Hourly"){
				ValidateHourly();
			}else if(CSVType == "Payment"){
				ValidatePayment();
			}else if(CSVType == "Canceled"){
				ValidateCanceled();
			}else if(CSVType == "Sales"){
				ValidateSales();
			}
		}
	}

	function DisableFields(){
		var TargetDate = $("#txtInputDateCSV").val();
		var TenantID = $("#TPTenantID").val();
		if(TenantID == ""){

		}else{
			$.ajax({
				type: 'POST',
				url: 'tenantportal/class.php',
				data: 'TargetDate=' + TargetDate + '&TenantID=' + TenantID + '&form=DisableFields',
				success:function(data){
					var arr = data.split("|");
					if(arr[0] == 1){
						$("#txtInputDiscountCSV").prop("disabled", true);
					}else{
						$("#txtInputDiscountCSV").prop("disabled", false);
					}
					if(arr[1] == 1){
						$("#txtInputHourlyCSV").prop("disabled", true);
					}else{
						$("#txtInputHourlyCSV").prop("disabled", false);
					}
					if(arr[2] == 1){
						$("#txtInputPaymentCSV").prop("disabled", true);
					}else{
						$("#txtInputPaymentCSV").prop("disabled", false);
					}
					if(arr[3] == 1){
						$("#txtInputRoCCSV").prop("disabled", true);
					}else{
						$("#txtInputRoCCSV").prop("disabled", false);
					}
					if(arr[4] == 1){
						$("#txtInputSalesCSV").prop("disabled", true);
					}else{
						$("#txtInputSalesCSV").prop("disabled", false);
					}
					if(arr[0] == 1 && arr[1] == 1 && arr[2] == 1 && arr[3] == 1 && arr[4] == 1){
						$("#btnUpload").prop("disabled", true);
					}else{
						$("#btnUpload").prop("disabled", false);
					}
				}
			})
		}
	}

	function ValidateAllFiles(){
		if($("#txtInputDiscountCSV").val() != "" && $("#txtInputHourlyCSV").val() != "" && $("#txtInputPaymentCSV").val() != "" && $("#txtInputRoCCSV").val() != "" && $("#txtInputSalesCSV").val() != ""){
			ValidateDiscount();
			ValidateHourly();
			ValidatePayment();
			ValidateCanceled();
			ValidateSales();
		}else if($("#txtInputDiscountCSV").val() == "" && $("#txtInputHourlyCSV").val() == "" && $("#txtInputPaymentCSV").val() == "" && $("#txtInputRoCCSV").val() == "" && $("#txtInputSalesCSV").val() == ""){
			$(".isValStat").css("display", "none");
		}
	}

	function ValidateDiscount(){
		var data = new FormData($('#csvFiles')[0]);
		$.ajax({
			type: 'POST',
			url: 'tenantportal/validatediscount.php',
			data: data,
			mimeType: 'multipart/form-data',
			contentType: false,
			cache: false,
			processData: false,
			beforeSend:function(){
				$('#indexloadingscreen').addClass('myspinner');
			},
			success:function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				var arr = data.split("|");
				if(arr[0] == "1"){
					$("#div_FileInputDiscount").find("a").click();
					$("#iValSuccessDiscount").css("display", "none");
					$("#iValFailedDiscount").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "Your target date is either less than the date you occupy or exceeds the date of your occupancy.", "", null, "", null, "1");
					}, 500)
				}else if(arr[0] == "2"){
					$("#div_FileInputDiscount").find("a").click();
					$("#iValSuccessDiscount").css("display", "none");
					$("#iValFailedDiscount").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "Filename of the selected CSV file doesn't match with your target date.", "", null, "", null, "1");
					}, 500)
				}else if(arr[0] == "3"){
					$("#div_FileInputDiscount").find("a").click();
					$("#iValSuccessDiscount").css("display", "none");
					$("#iValFailedDiscount").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "CSV file doesn't meet the required standard.", "", null, "", null, "1");
					}, 500)
				}else{
					$("#iValSuccessDiscount").css("display", "block");
					$("#iValFailedDiscount").css("display", "none");
				}
			}
		});
	}

	function ValidateHourly(){
		var data = new FormData($('#csvFiles')[0]);
		$.ajax({
			type: 'POST',
			url: 'tenantportal/validatehourly.php',
			data: data,
			mimeType: 'multipart/form-data',
			contentType: false,
			cache: false,
			processData: false,
			beforeSend:function(){
				$('#indexloadingscreen').addClass('myspinner');
			},
			success:function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				var arr = data.split("|");
				if(arr[0] == "1"){
					$("#div_FileInputHourly").find("a").click();
					$("#iValSuccessHourly").css("display", "none");
					$("#iValFailedHourly").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "Your target date is either less than the date you occupy or exceeds the date of your occupancy.", "", null, "", null, "1");
					}, 500)
				}else if(arr[0] == "2"){
					$("#div_FileInputHourly").find("a").click();
					$("#iValSuccessHourly").css("display", "none");
					$("#iValFailedHourly").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "Filename of the selected CSV file doesn't match with your target date.", "", null, "", null, "1");
					}, 500)
				}else if(arr[0] == "3"){
					$("#div_FileInputHourly").find("a").click();
					$("#iValSuccessHourly").css("display", "none");
					$("#iValFailedHourly").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "CSV file doesn't meet the required standard.", "", null, "", null, "1");
					}, 500)
				}else if(arr[0] == "4"){
					$("#div_FileInputHourly").find("a").click();
					$("#iValSuccessHourly").css("display", "none");
					$("#iValFailedHourly").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "CSV file for hourly sales cannot be blank.", "", null, "", null, "1");
					}, 500)
				}else{
					$("#iValSuccessHourly").css("display", "block");
					$("#iValFailedHourly").css("display", "none");
				}
			}
		});
	}

	function ValidatePayment(){
		var data = new FormData($('#csvFiles')[0]);
		$.ajax({
			type: 'POST',
			url: 'tenantportal/validatepayment.php',
			data: data,
			mimeType: 'multipart/form-data',
			contentType: false,
			cache: false,
			processData: false,
			beforeSend:function(){
				$('#indexloadingscreen').addClass('myspinner');
			},
			success:function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				var arr = data.split("|");
				if(arr[0] == "1"){
					$("#div_FileInputPayment").find("a").click();
					$("#iValSuccessPayment").css("display", "none");
					$("#iValFailedPayment").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "Your target date is either less than the date you occupy or exceeds the date of your occupancy.", "", null, "", null, "1");
					}, 500)
				}else if(arr[0] == "2"){
					$("#div_FileInputPayment").find("a").click();
					$("#iValSuccessPayment").css("display", "none");
					$("#iValFailedPayment").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "Filename of the selected CSV file doesn't match with your target date.", "", null, "", null, "1");
					}, 500)
				}else if(arr[0] == "3"){
					$("#div_FileInputPayment").find("a").click();
					$("#iValSuccessPayment").css("display", "none");
					$("#iValFailedPayment").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "CSV file doesn't meet the required standard.", "", null, "", null, "1");
					}, 500)
				}else{
					$("#iValSuccessPayment").css("display", "block");
					$("#iValFailedPayment").css("display", "none");
				}
			}
		});
	}

	function ValidateCanceled(){
		var data = new FormData($('#csvFiles')[0]);
		$.ajax({
			type: 'POST',
			url: 'tenantportal/validatecanceled.php',
			data: data,
			mimeType: 'multipart/form-data',
			contentType: false,
			cache: false,
			processData: false,
			beforeSend:function(){
				$('#indexloadingscreen').addClass('myspinner');
			},
			success:function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				var arr = data.split("|");
				if(arr[0] == "1"){
					$("#div_FileInputCanceled").find("a").click();
					$("#iValSuccessCancelled").css("display", "none");
					$("#iValFailedCancelled").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "Your target date is either less than the date you occupy or exceeds the date of your occupancy.", "", null, "", null, "1");
					}, 500)
				}else if(arr[0] == "2"){
					$("#div_FileInputCanceled").find("a").click();
					$("#iValSuccessCancelled").css("display", "none");
					$("#iValFailedCancelled").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "Filename of the selected CSV file doesn't match with your target date.", "", null, "", null, "1");
					}, 500)
				}else if(arr[0] == "3"){
					$("#div_FileInputCanceled").find("a").click();
					$("#iValSuccessCancelled").css("display", "none");
					$("#iValFailedCancelled").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "CSV file doesn't meet the required standard.", "", null, "", null, "1");
					}, 500)
				}else{
					$("#iValSuccessCancelled").css("display", "block");
					$("#iValFailedCancelled").css("display", "none");
				}
			}
		});
	}

	function ValidateSales(){
		var data = new FormData($('#csvFiles')[0]);
		$.ajax({
			type: 'POST',
			url: 'tenantportal/validatesales.php',
			data: data,
			mimeType: 'multipart/form-data',
			contentType: false,
			cache: false,
			processData: false,
			beforeSend:function(){
				$('#indexloadingscreen').addClass('myspinner');
			},
			success:function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				var arr = data.split("|");
				if(arr[0] == "1"){
					$("#div_FileInputSales").find("a").click();
					$("#iValSuccessSales").css("display", "none");
					$("#iValFailedSales").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "Your target date is either less than the date you occupy or exceeds the date of your occupancy.", "", null, "", null, "1");
					}, 500)
				}else if(arr[0] == "2"){
					$("#div_FileInputSales").find("a").click();
					$("#iValSuccessSales").css("display", "none");
					$("#iValFailedSales").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "Filename of the selected CSV file doesn't match with your target date.", "", null, "", null, "1");
					}, 500)
				}else if(arr[0] == "3"){
					$("#div_FileInputSales").find("a").click();
					$("#iValSuccessSales").css("display", "none");
					$("#iValFailedSales").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "CSV file doesn't meet the required standard.", "", null, "", null, "1");
					}, 500)
				}else if(arr[0] == "4"){
					$("#div_FileInputSales").find("a").click();
					$("#iValSuccessSales").css("display", "none");
					$("#iValFailedSales").css("display", "block");
					setTimeout(function(){
						showmodal("alert", "Number of rows inside the CSV file doesn't match with your POS setup.", "", null, "", null, "1");
					}, 500)
				}else{
					$("#iValSuccessSales").css("display", "block");
					$("#iValFailedSales").css("display", "none");
				}
			}
		});
	}

	function uploadcsvfiles(){
		var data = new FormData($('#csvFiles')[0]);
		$.ajax({
			type: 'POST',
			url: 'tenantportal/savecsvfile.php',
			data: data,
			mimeType: 'multipart/form-data',
			contentType: false,
			cache: false,
			processData: false,
			beforeSend:function(){
				$('#indexloadingscreen').addClass('myspinner');
			},
			success:function(data){
				$('#indexloadingscreen').removeClass('myspinner');
				var arr = data.split("|");
				if(arr[0] == "2"){
					setTimeout(function(){
						showmodal("alert", "Please select atleast 1 CSV file to upload.", "", null, "", null, "1");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", arr[1], "confirmsuccessandclear", null, "", null, "0");
					}, 500)
				}
			}
		});
	}

	function confirmsuccessandclear(){
		$(".remove").click();
		$(".isValStat").css("display", "none");
		csvfolders();
		DisableFields();
	}

	function csvfolders(){
		var TenantID = $("#TPTenantID").val();
		$.ajax({
			type: 'POST',
			url: 'tenantportal/class.php',
			data: 'TenantID=' + TenantID + '&form=csvfolders',
			success:function(data){
				$("#csvfolders").html(data);
				$(".csvlist li").on("click", function (e) {
				e.stopPropagation();
					$(this).children('ul').toggle();
					var icon = $(this).find("i");
					icon.toggleClass("fa-folder-open fa-folder");
				});
				$("li .clickcsvlist").each(function(){
					$(this).click();
				})
			}
		})
	}

	function getdata(){
		var TenantID = $("#TPTenantID").val();
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'tenantportal/class.php',
			data: 'TenantID=' + TenantID + '&form=getdata',
			success:function(data){
				arr = data;
			}
		});
		return arr;
	}

	function getMonthlyDD(){
		var TenantID = $("#TPTenantID").val();
		var arr = '';
		$.ajax({
			type: 'POST',
			async: false,
			url: 'tenantportal/class.php',
			data: 'TenantID=' + TenantID + '&form=getMonthlyDD',
			success:function(data){
				arr = data;
			}
		});
		return arr;
	}

	function showgraph(){
		var arrdata = JSON.parse(getdata());
		var arrdata2 = JSON.parse(getMonthlyDD());
		Highcharts.chart('drilldowngraph', {
			chart: {
				type: 'column'
			},
			credits: {
				enabled: false
			},
			title: {
				text: 'Monthly Total Sales For the Year <?php echo date('Y'); ?>' 
			},
			xAxis: {
				type: 'category'
			},
			yAxis: {
				title: {
					text: 'Total Sales'
				}
			},
			legend: {
				enabled: false
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: false
					}
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:18px">{series.name}</span><br>',
				pointFormat: '<span style="font-size: 18px;">{point.name}</span>: <b>{point.y}</b>',
				valueDecimals: 2,
				valuePrefix: 'P',
			},
			series: [{
				name: 'Monthly Sales',
				colorByPoint: true,
				data: arrdata,
			}],drilldown: {
				series: arrdata2
			}
		});
	}

	function tbltptenantlist(){
		var key = $("#txtSearchTradeTP").val();
		$.ajax({
			type: 'POST',
			url: 'tenantportal/class.php',
			data: 'key=' + key + '&form=tbltptenantlist',
			success:function(data){
				$("#tbltptenantlist").html(data);
				tbltptenantlistClick();
			}
		})
	}

	function ConsolidateCSV(){
		var Month = $("#txtInputConsoliDate").val();
		$.ajax({
			type: 'POST',
			url: 'tenantportal/class.php',
			data: 'Month=' + Month + '&form=ConsolidateCSV',
			success:function(data){
				var arr = data.split("|");
				$("#tbodyConsolidatedSales").html(arr[0]);
				setTimeout(function(){
					exportTableToCSV(arr[1]);
				}, 1000)
			}
		})
	}

	function exportTableToCSV(filename){
		var csv = [];
		var rows = document.querySelectorAll("#tblConsolidatedSales tr");

		for (var i = 0; i < rows.length; i++) {
			var row = [], cols = rows[i].querySelectorAll("#tblConsolidatedSales th, #tblConsolidatedSales td");
			
			for (var j = 0; j < cols.length; j++) 
				row.push(cols[j].innerText);
			
			csv.push(row.join(","));        
		}
		// Download CSV file
		downloadCSV(csv.join("\n"), filename);
	}

	function downloadCSV(csv, filename) {
		var csvFile;
		var downloadLink;

		// CSV file
		csvFile = new Blob([csv], {type: "text/csv"});

		// Download link
		downloadLink = document.createElement("a");

		// File name
		downloadLink.download = filename;

		// Create a link to the file
		downloadLink.href = window.URL.createObjectURL(csvFile);

		// Hide download link
		downloadLink.style.display = "none";

		// Add the link to DOM
		document.body.appendChild(downloadLink);

		// Click download link
		downloadLink.click();
	}




	// DAILY SALES REPORT
	// ADDED BY PETER - SEPTEMBER 8, 2019
	//  MODIFIED BY PETER SEPTEMBER 29, 2019

	function getDates() {
		$.ajax ({
			type: 'POST',
			url: 'tenantportal/class.php',
			data: 'form=getDates',
			success: function(data) {
				$(".date-filter").val(data);
				$(".date-filter").keypress(function(){
					return false;
				})
			}
		})
		
	}

	// FUNCTION FOR GENERATING DATES
	function generateSRDate2() {
		var pgCount = $("#pgGenerated").val();
		var tenantid = $("#tpTenantID").text();
		var dateFrom = $("#txtSRdateFrom").val();
		var dateTo = $("#txtSRdateTo").val();
		if ( tenantid == "" ) {
			showmodal("alert", "Please select tenant first.", "", null, "", null, "0");
		} else {
			$.ajax ({
				type: 'POST',
				url: 'tenantportal/class.php',
				data: 'pgCount=' + pgCount + '&tenantid=' + tenantid + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&form=generateSRDate',
				success: function(data) {
					$("#tblsalesReport").html(data);
					allownumbers();
					saveSalesReport();
				}
			})
		}	
	}

	var pgCount = 0;
	function generateSRDate(pgCount) {
		var pgCount2 = 0;
		if ( (pgCount == "undefined") || (pgCount == "") ) {
			pgCount2 = $("#pgGenerated").val();
		} else {
			pgCount2 = pgCount;
		}
		var dateFrom = $("#txtSRdateFrom").val();
		var dateTo = $("#txtSRdateTo").val();

		$.ajax ({
			type: 'POST',
			url: 'tenantportal/class.php',
			data: 'pgCount=' + pgCount2 + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&form=generateSalesPage',
			success: function(data) {
				$("#body-pagination").html(data);
				$("#pgGenerated").val(pgCount2);

				generateSRDate2();
				getTotalSales();
			}
		})
	}

	function allownumbers() {
		$(".numberslang").each(function(){
			$(this).keypress(function(event) {
				if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57 || event.which == 44 )) {
					event.preventDefault();
				}
			}); 
		})
	}

	function saveSalesReport() {
		$("#tblsalesReport tr").each(function(){
			var eto = $(this);
			var eto2 = eto.find(".form-control");
			eto2.blur(function(){
				var tenantid = $("#tpTenantID").text();
				var id = eto.prop("id");
				var amt = eto2.val().replace(/,/g, "");
				var selectedDate = eto.find("td").eq(0).text();
				// alert(amt);
				$.ajax ({
					type: 'POST',
					url: 'tenantportal/class.php',
					data: 'tenantid=' + tenantid + '&id=' + id + '&selectedDate=' + selectedDate + '&amt=' + amt + '&form=saveSalesReport',
					success:function(data){
						if ( data == 1 ) {
							generateSRDate("");
							getTotalSales();
						}
					}
				})
			})
		})
	}

	function getTotalSales() {
		var dateFrom = $("#txtSRdateFrom").val();
		var dateTo = $("#txtSRdateTo").val();
		var tenantid = $("#tpTenantID").text();

		$.ajax ({
			type: 'POST',
			url: 'tenantportal/class.php',
			data: 'tenantid=' + tenantid + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&form=getTotalSales',
			success: function(data) {
				$("#magkanoHalaga").html(data);
			}
		})
	}

	function tbltptenantlistClick() {
		$("#tbltptenantlist li").each(function(){
			var eto = $(this);
			eto.click(function(){
				$("#tbltptenantlist li").removeClass("selected");
				eto.addClass("selected");
				var tenantid = eto.prop("id");
				$("#TPTenantID").val(tenantid);
				var TargetDate = $("#txtInputDateCSV").val();
				$.ajax({
					type: 'POST',
					url: 'tenantportal/class.php',
					data: 'TenantID=' + tenantid + '&form=TenantInfo',
					success:function(data){
						var arr = data.split("|");
						$("#tpCompanyName").text(arr[0]);
						$("#tpTenantID").text(arr[1]);
						$("#tpMerchantCode").text(arr[2]);
						$("#tpMall").text(arr[3]);
						$("#tpUnitNumber").text(arr[4]);
						$("#tpProfilePicture").attr("alt", arr[0] +"'s Photo");
						$("#tpProfilePicture").attr("src", arr[5]);
					}
				})
				$.ajax({
					type: 'POST',
					url: 'tenantportal/class.php',
					data: 'TenantID=' + tenantid + '&form=showpendingcomplaints',
					success:function(data){
						$("#tpComplaintsCount").text(data);
					}
				})
				$.ajax({
					type: 'POST',
					url: 'tenantportal/class.php',
					data: 'TenantID=' + tenantid + '&form=showpendingworkorder',
					success:function(data){
						$("#tpWorkOrderCount").text(data);
					}
				})
				$.ajax({
					type: 'POST',
					url: 'tenantportal/class.php',
					data: 'TenantID=' + tenantid + '&form=showpenalty',
					success:function(data){
						$("#tpPenaltyCount").text(data);
					}
				})
				$.ajax({
					type: 'POST',
					url: 'tenantportal/class.php',
					data: 'TargetDate=' + TargetDate + '&TenantID=' + tenantid + '&form=DisableFields',
					success:function(data){
						var arr = data.split("|");
						if(arr[0] == 1){
							$("#txtInputDiscountCSV").prop("disabled", true);
						}else{
							$("#txtInputDiscountCSV").prop("disabled", false);
						}
						if(arr[1] == 1){
							$("#txtInputHourlyCSV").prop("disabled", true);
						}else{
							$("#txtInputHourlyCSV").prop("disabled", false);
						}
						if(arr[2] == 1){
							$("#txtInputPaymentCSV").prop("disabled", true);
						}else{
							$("#txtInputPaymentCSV").prop("disabled", false);
						}
						if(arr[3] == 1){
							$("#txtInputRoCCSV").prop("disabled", true);
						}else{
							$("#txtInputRoCCSV").prop("disabled", false);
						}
						if(arr[4] == 1){
							$("#txtInputSalesCSV").prop("disabled", true);
						}else{
							$("#txtInputSalesCSV").prop("disabled", false);
						}
						if(arr[0] == 1 && arr[1] == 1 && arr[2] == 1 && arr[3] == 1 && arr[4] == 1){
							$("#btnUpload").prop("disabled", true);
						}else{
							$("#btnUpload").prop("disabled", false);
						}
					}
				})
				$("#txtInputDateCSV").prop("disabled", false);
				showgraph();
				csvfolders();
				generateSRDate('0');
			})
		})
	}
</script>