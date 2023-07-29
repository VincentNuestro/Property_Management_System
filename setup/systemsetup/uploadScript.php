<script type="text/javascript">
	var saveStateUpload = 0;
	function uploadCSV() {
		var csvType = $("#CSVType").val();

		if ( $("#refCSV").val() != "" ) {
			var csvDetails = "";
			var saveForm = "";
			if ( csvType == 'mallSetup' ) {
				$("#tblMallUpload tr").each(function(){
					var eto = $(this);
					csvDetails += "#||";
					eto.find("td").each(function(){
						csvDetails += $(this).text() + "|||";
					})
				})

				saveForm = "uploadMall";
			}

			else if ( csvType == 'category' ) {
				$("#tblCategoryUpload tr").each(function(){
					var eto = $(this);
					csvDetails += "#||";
					eto.find("td").each(function(){
						csvDetails += $(this).text() + "|||";
					})
				})

				saveForm = "category";
			}

			else if ( csvType == 'classification' ) {
				$("#tblClassUpload tr").each(function(){
					var eto = $(this);
					csvDetails += "#||";
					eto.find("td").each(function(){
						csvDetails += $(this).text() + "|||";
					})
				})

				saveForm = "classification";
			}

			else if ( csvType == 'wing' ) {
				$("#tblWingUpload tr").each(function(){
					var eto = $(this);
					csvDetails += "#||";
					eto.find("td").each(function(){
						csvDetails += $(this).text() + "|||";
					})
				})

				saveForm = "wing";
			}

			else if ( csvType == 'floorName' ) {
				$("#tblFloorNameUpload tr").each(function(){
					var eto = $(this);
					csvDetails += "#||";
					eto.find("td").each(function(){
						csvDetails += $(this).text() + "|||";
					})
				})

				saveForm = "floorName";
			}

			else if ( csvType == 'floorSetup' ) {
				$("#tblFloorSetupUpload tr").each(function(){
					var eto = $(this);
					csvDetails += "#||";
					eto.find("td").each(function(){
						csvDetails += $(this).text() + "|||";
					})
				})

				saveForm = "floorSetup";
			}

			else if ( csvType == 'department' ) {
				$("#tblDepartmentUpload tr").each(function(){
					var eto = $(this);
					csvDetails += "#||";
					eto.find("td").each(function(){
						csvDetails += $(this).text() + "|||";
					})
				})

				saveForm = "department";
			}

			else if ( csvType == 'industry' ) {
				$("#tblIndustryUpload tr").each(function(){
					var eto = $(this);
					csvDetails += "#||";
					eto.find("td").each(function(){
						csvDetails += $(this).text() + "|||";
					})
				})

				saveForm = "industry";
			}

			else if ( csvType == 'amenities' ) {
				$("#tblAmenitiesUpload tr").each(function(){
					var eto = $(this);
					csvDetails += "#||";
					eto.find("td").each(function(){
						csvDetails += $(this).text() + "|||";
					})
				})

				saveForm = "amenities";
			}

			else if ( csvType == 'unit' ) {
				$("#tblUnitUpload tr").each(function(){
					var eto = $(this);
					csvDetails += "#||";
					eto.find("td").each(function(){
						csvDetails += $(this).text() + "|||";
					})
				})

				saveForm = "unit";
			}

			else if ( csvType == 'company' ) {
				$("#tblCompanyUpload tr").each(function(){
					var eto = $(this);
					csvDetails += "#||";
					eto.find("td").each(function(){
						csvDetails += $(this).text() + "|||";
					})
				})

				saveForm = "company";
			}

			// alert(csvDetails);

			if ( saveStateUpload == 0 ) {
				saveStateUpload = 1;
				$.ajax ({
					type: 'POST',
					url: 'setup/systemsetup/class2.php',
					data: 'csvType=' + csvType + '&csvDetails=' + csvDetails + '&form=' + saveForm,
					success: function(data) {
						if ( data == 1 ) {
							// alert(data);
							
							showmodal("alert", "CSV details successfully uploaded.", "", null, "", null, "0");
							setTimeout(function(){
								saveStateUpload = 0;
							}, 1000)
						}

						else if ( data == 2 ){
							showmodal("alert", "Unable to upload CSV multiple times.", "", null, "", null, "0");
						}

						else {
							alert(data);
						}
					}
				})
			}
		}

		else {
			showmodal("alert", "There is no available CSV file to be upload.", "", null, "", null, "0");
		}
	}

	function startUpload() {
		var RefType = $("#CSVType").val();

		if ( RefType == 'mallSetup' ) {
			displayMallCSV();
		}

		else if ( RefType == 'category' ) {
			displayCategory();
		}

		else if ( RefType == 'classification' ) {
			displayCategory();
		}

		else if ( RefType == 'wing' ) {
			displayWing();
		}

		else if ( RefType == 'floorName' ) {
			displayFloorName();
		}

		else if ( RefType == 'floorSetup' ) {
			displayFloorSetup();
		}

		else if ( RefType == 'department' ) {
			displayDepartment();
		}

		else if ( RefType == 'industry' ) {
			displayIndustry();
		}

		else if ( RefType == 'amenities' ) {
			displayAmenities();
		}

		else if ( RefType == 'unit' ) {
			displayUnit();
		}

		else if ( RefType == 'company' ) {
			displayCompany();
		}
	}

	function displayMallCSV() {
		var file_data = $('#refCSV').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);  
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/uploadMall/class.php',
			// dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			// data: 'form_data=' + form_data + '&form=displayMalls',
			data: form_data,
			
			success: function(data){
				var arr = data.split("|");

				if ( arr[0] == 1 ) {
					$("#tblMallUpload").html(arr[1]);
				}
				else {
					showmodal("alert", arr[1], "", null, "", null, "0");
				}
			}
		});
	}

	function displayCategory() {
		var file_data = $('#refCSV').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);  
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/uploadCategory/class.php',
			// dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			// data: 'form_data=' + form_data + '&form=displayMalls',
			data: form_data,
			
			success: function(data){
				var arr = data.split("|");

				if ( arr[0] == 1 ) {
					$("#tblCategoryUpload").html(arr[1]);
				}
				else {
					showmodal("alert", arr[1], "", null, "", null, "0");
				}
			}
		});
	}

	function displayCategory() {
		var file_data = $('#refCSV').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);  
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/uploadClassification/class.php',
			// dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			// data: 'form_data=' + form_data + '&form=displayMalls',
			data: form_data,
			
			success: function(data){
				var arr = data.split("|");

				if ( arr[0] == 1 ) {
					$("#tblClassUpload").html(arr[1]);
				}
				else {
					showmodal("alert", arr[1], "", null, "", null, "0");
				}
			}
		});
	}

	function displayWing() {
		var file_data = $('#refCSV').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);  
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/uploadWing/class.php',
			// dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			// data: 'form_data=' + form_data + '&form=displayMalls',
			data: form_data,
			
			success: function(data){
				var arr = data.split("|");

				if ( arr[0] == 1 ) {
					$("#tblWingUpload").html(arr[1]);
				}
				else {
					showmodal("alert", arr[1], "", null, "", null, "0");
				}
			}
		});
	}

	function displayFloorName() {
		var file_data = $('#refCSV').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);  
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/uploadFloorName/class.php',
			// dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			// data: 'form_data=' + form_data + '&form=displayMalls',
			data: form_data,
			
			success: function(data){
				var arr = data.split("|");

				if ( arr[0] == 1 ) {
					$("#tblFloorNameUpload").html(arr[1]);
				}
				else {
					showmodal("alert", arr[1], "", null, "", null, "0");
				}
			}
		});
	}

	function displayFloorSetup() {
		var file_data = $('#refCSV').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);  
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/uploadFloorSetup/class.php',
			// dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			// data: 'form_data=' + form_data + '&form=displayMalls',
			data: form_data,
			
			success: function(data){
				var arr = data.split("|");

				if ( arr[0] == 1 ) {
					$("#tblFloorSetupUpload").html(arr[1]);
				}
				else {
					showmodal("alert", arr[1], "", null, "", null, "0");
				}
			}
		});
	}

	function displayDepartment() {
		var file_data = $('#refCSV').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);  
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/uploadDepartment/class.php',
			// dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			// data: 'form_data=' + form_data + '&form=displayMalls',
			data: form_data,
			
			success: function(data){
				var arr = data.split("|");

				if ( arr[0] == 1 ) {
					$("#tblDepartmentUpload").html(arr[1]);
				}
				else {
					showmodal("alert", arr[1], "", null, "", null, "0");
				}
			}
		});
	}

	function displayIndustry() {
		var file_data = $('#refCSV').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);  
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/uploadIndustry/class.php',
			// dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			// data: 'form_data=' + form_data + '&form=displayMalls',
			data: form_data,
			
			success: function(data){
				var arr = data.split("|");

				if ( arr[0] == 1 ) {
					$("#tblIndustryUpload").html(arr[1]);
				}
				else {
					showmodal("alert", arr[1], "", null, "", null, "0");
				}
			}
		});
	}

	function displayAmenities() {
		var file_data = $('#refCSV').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);  
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/uploadAmenities/class.php',
			// dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			// data: 'form_data=' + form_data + '&form=displayMalls',
			data: form_data,
			
			success: function(data){
				var arr = data.split("|");

				if ( arr[0] == 1 ) {
					$("#tblAmenitiesUpload").html(arr[1]);
				}
				else {
					showmodal("alert", arr[1], "", null, "", null, "0");
				}
			}
		});
	}

	function displayUnit() {
		var file_data = $('#refCSV').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);  
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/uploadUnit/class.php',
			// dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			// data: 'form_data=' + form_data + '&form=displayMalls',
			data: form_data,
			
			success: function(data){
				var arr = data.split("|");

				if ( arr[0] == 1 ) {
					$("#tblUnitUpload").html(arr[1]);
				}
				else {
					showmodal("alert", arr[1], "", null, "", null, "0");
				}
			}
		});
	}

	function displayCompany() {
		var file_data = $('#refCSV').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);  
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/uploadCompany/class.php',
			// dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			// data: 'form_data=' + form_data + '&form=displayMalls',
			data: form_data,
			
			success: function(data){
				var arr = data.split("|");

				if ( arr[0] == 1 ) {
					$("#tblCompanyUpload").html(arr[1]);
				}
				else {
					showmodal("alert", arr[1], "", null, "", null, "0");
				}
			}
		});
	}
</script>