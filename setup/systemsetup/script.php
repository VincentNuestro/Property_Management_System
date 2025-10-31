<script type="text/javascript">
	$(function(){
		$('#txtSetupLPFontColor').colorpicker({
			customClass: 'custom-size',
			sliders: {
				saturation: {
					maxLeft: 250,
					maxTop: 250
				},
				hue: {
					maxTop: 250
				},
				alpha: {
					maxTop: 250
				}
			}
		});
		loadsetup();
		$('.companyimage').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false
		});
		$(".disablemoko").prop("disabled", true);
		$(".input-mask-tele").on('keypress', function (event) {
        var regex = new RegExp("^[-+() 0-9]+");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
		$('.input-mask-phone').mask('(999) 999-9999');
		$(".numberlang").keydown(function (e){ 
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || 
				(e.keyCode == 65 && e.ctrlKey === true) ||  
				(e.keyCode >= 35 && e.keyCode <= 40)) { 
				return;
			} 
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		$('.UploadRef').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false //| true | large
		});
	});
	
	function loadsetup(){
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/class.php',
			data: 'form=loadsetup',
			success: function(data){
				var arr = data.split("|");
				$("#txtcorporatename").val(arr[1]);
				$("#txtcompanyabout").val(arr[2]);
				$("#txtcompanyaddress").val(arr[3]);
				$("#txtcompanymobilenum").val(arr[4]);
				$("#txtnumofmall").val(arr[6]);
				$("#txtcompanyemail").val(arr[5]);
				$(".txtcompanytemplate").each(function(){
					if($(this).val() == arr[7]){ 
						$(this).prop("checked", true); 
					}
				});
				$("#imgg1").attr("src", arr[8]);
				$("#wards").val(arr[9]);
				$("#txtmallprefix").val(arr[10]);
				$("#txtinqprefix").val(arr[11]);
				$("#txtappprefix").val(arr[12]);
				$("#txtTIN").val(arr[14]);
				$("#txttelephone").val(arr[15]);
				$("#txtfax").val(arr[16]);
				$("#txtwebsite").val(arr[17]);
				$("#txtmachineno").val(arr[18]);
				$("#txtserialno").val(arr[19]);
				$("#txtaccreditationno").val(arr[20]);
				$("#txtcompanysetup").val(arr[21]);
				$("#txtcsvpath").val(arr[22]);
				$(".btnsoftwaretype").each(function(){
					if($(this).val() == arr[21]){ 
						$(this).prop("checked", true); 
					}
				});
				$("#txtdbsetup").val(arr[23]);
				$("#txtCSVHost").val(arr[24]);
				$("#txtCSVPort").val(arr[25]);
				$("#btnsetupsave").css("display", "none");
				$("#btnsetupcancel").css("display", "none");
			}
		})
	}

	function trap(){
		$('.email-address').each(function(){
			$(this).focusout(function() {
				var sEmail = $(this).val();
				if($.trim(sEmail).length == 0){

				}
				if(validateEmail(sEmail)){

				}else{
					setTimeout(function(){
						showmodal("alert", "The email address you entered is in invalid format.", "", null, "", null, "0");
					}, 500)
				}
			});
		});

		$('.website-input').each(function(){
		$(this).focusout(function() {
			var sEmail = $(this).val();
			if ($.trim(sEmail).length == 0) {
				e.preventDefault();
			}
			if (validatWebsite(sEmail)) {
				$(".errohere").hide();
			}else{
				setTimeout(function(){
					showmodal("alert", "The website you entered is in invalid format.", "", null, "", null, "0");
				}, 500)
				$(this).val("")
				e.preventDefault();
			}
		});
	});       
	}

	function validateEmail(sEmail) {
		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		if (filter.test(sEmail)) {
			return true;
		}else{
			return false;
		}
	}

	function validatWebsite(sEmail) {
		var filter = /www.((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		if (filter.test(sEmail)) {
			return true;
		}else{
			return false;
		}
	}

	function showimggggggsetup(){
		var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById("file1").files[0]);
		oFReader.onload = function (oFREvent) {
			document.getElementById("imgg1").src = oFREvent.target.result;
		};
	}

	function editsetup(){
		$("#btnsetupsave").css("display", "block");
		$("#btnsetupcancel").css("display", "block");
		$("#btnsetupedit").css("display", "none");
		$(".disablemoko").prop("disabled", false);
	}

	function canceleditsetup(){
		$("#btnsetupsave").css("display", "none");
		$("#btnsetupcancel").css("display", "none");
		$("#btnsetupedit").css("display", "block");
		loadsetup();
		$(".disablemoko").prop("disabled", true);
	}

	function savesystemsetup(){
		var softwaretype = $("#txtcompanysetup").val();
		var name = $("#txtcorporatename").val();
		var address = $("#txtcompanyaddress").val();
		var about = $("#txtcompanyabout").val();
		var email = $("#txtcompanyemail").val();
		var website = $("#txtwebsite").val();
		var mobilenum = $("#txtcompanymobilenum").val();
		var telephone = $("#txttelephone").val();
		var fax = $("#txtfax").val();
		var tin = $("#txtTIN").val();
		var csvpath = $("#txtcsvpath").val();
		var numofmall = $("#txtnumofmall").val();
		var mallprefix = $("#txtmallprefix").val();
		var inqprefix = $("#txtinqprefix").val();
		var appprefix = $("#txtappprefix").val();
		var machineno = $("#txtmachineno").val();
		var serialno = $("#txtserialno").val();
		var accreditation = $("#txtaccreditationno").val();
		var dbsetup = $("#txtdbsetup").val();
		var Host = $("#txtCSVHost").val();
		var Port = $("#txtCSVPort").val();
		var template = "";
		$(".txtcompanytemplate").each(function(){
			if($(this).is(":checked")){
				template = $(this).attr("value");
			}
		})
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/class.php',
			data: 'softwaretype=' + softwaretype + '&name=' + name + '&address=' + encodeURIComponent(address) + '&about=' + encodeURIComponent(about) + '&email=' + email + '&website=' + website + '&mobilenum=' + mobilenum + '&telephone=' + telephone + '&fax=' + fax + '&tin=' + tin + '&csvpath=' + encodeURIComponent(csvpath) + '&numofmall=' + numofmall + '&mallprefix=' + mallprefix + '&inqprefix=' + inqprefix + '&appprefix=' + appprefix + '&machineno=' + machineno + '&serialno=' + serialno + '&accreditation=' + accreditation + '&template=' + template + '&dbsetup=' + dbsetup + '&Host=' + encodeURIComponent(Host) + '&Port=' + Port + '&form=savesystemsetup',
			success: function(data){
				var arr = data.split("|");
				if(arr[0].trim() == "2"){
					setTimeout(function(){
						showmodal("alert", arr[1], "reloadPage", null, "", null, "0");
					}, 500)
					posting_companypicture();
				}else{
					setTimeout(function(){
						showmodal("alert", arr[1], "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function reloadPage(){
		window.location.reload();
	}

	function posting_companypicture(){
		var data = new FormData($('#posting_companypicture')[0]);
		$.ajax({
			type:"POST",
			url:"setup/systemsetup/savesetup.php",
			data: data,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			success: function(data){
				
			}
		});
	}

	function openconnectionsetup(){
		$("#setupconnection").modal("show");
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/class.php',
			data: 'form=loadconnectionsetup',
			success: function(data){
				var arr = data.split("|");
				$("#txtHostAddress").val(arr[0]);
				$("#txtUsername").val(arr[1]);
				$("#txtPassword").val(arr[2]);
				$("#txtPort").val(arr[3]);
			}
		})
	}

	function closeconnectionsetup(){
		$("#setupconnection").modal("hide");
		$("#setupconnection :input").val("");
	}

	function testconnection(){
		var HostAddress = $("#txtHostAddress").val();
		var Username = $("#txtUsername").val();
		var Password = $("#txtPassword").val();
		var Port = $("#txtPort").val();
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/class.php',
			data: 'HostAddress=' + HostAddress + '&Username=' + Username + '&Password=' + Password + '&Port=' + Port + '&form=testconnection',
			beforeSend(){
				$('#preloadforconnectionsetup').addClass('myspinner');
			},
			success: function(data){
				$('#preloadforconnectionsetup').removeClass('myspinner');
				if(data.trim() == "1"){
					setTimeout(function(){
						showmodal("alert", "Connection successful.", "", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Unable to connect, please check your host address, username and password.", "", null, "", null, "1");
					}, 500)
				}
			}
		})
	}

	function disablenotincludedfields(){
		var systype = $("#txtcompanysetup").val();
		if(systype == "0"){
			$(".txtSysLabel1").text("Mall");
			$(".withPOS").removeClass("hide");
		}else if(systype == "1"){
			$(".txtSysLabel1").text("Building");
			$(".withPOS").addClass("hide");
		}else if(systype == "2"){
			$(".txtSysLabel1").text("Building");
			$(".withPOS").addClass("hide");
		}else if(systype == "3"){
			$(".txtSysLabel1").text("Palengke");
			$(".withPOS").addClass("hide");
		}else if(systype == "4"){
			$(".txtSysLabel1").text("Cemetery");
			$(".withPOS").addClass("hide");
		}else if(systype == "5"){
			$(".txtSysLabel1").text("Property");
			$(".withPOS").addClass("hide");
		}
	}

	function SaveLeaseSys(){
		var Setup1 = "";
		$(".rdRequirementandPermit").each(function(){
			if($(this).is(":checked")){
				Setup1 = $(this).val();
			}
		})
		var Setup2 = "";
		$(".rdAdjustOccupancy").each(function(){
			if($(this).is(":checked")){
				Setup2 = $(this).val();
			}
		})
		var Setup3 = "";
		$(".rdAutoMerchantCode").each(function(){
			if($(this).is(":checked")){
				Setup3 = $(this).val();
			}
		})
		var FlrUnit = $("#slctFlrUnitMeasurement").val();
		var Setup4 = "";
		$(".rdVatSetup").each(function(){
			if($(this).is(":checked")){
				Setup4 = $(this).val();
			}
		})
		var isClassification = "";
		$(".isClassification").each(function(){
			if($(this).is(":checked")){
				if($(this).val() == "Classification"){
					isClassification = 1;
				}
			}else{
				isClassification = 0;
			}
		})
		var isDepartment = "";
		$(".isDepartment").each(function(){
			if($(this).is(":checked")){
				if($(this).val() == "Department"){
					isDepartment = 1;
				}
			}else{
				isDepartment = 0;
			}
		})
		var isCategory = "";
		$(".isCategory").each(function(){
			if($(this).is(":checked")){
				if($(this).val() == "Category"){
					isCategory = 1;
				}
			}else{
				isCategory = 0;
			}
		})
		var isAssocDues = "";
		$(".rdAssocDues").each(function(){
			if($(this).is(":checked")){
				isAssocDues = $(this).val();
			}
		})
		var isMultiCompSig = "";
		$(".rdMultiCompSig").each(function(){
			if($(this).is(":checked")){
				isMultiCompSig = $(this).val();
			}
		})
		var isOccupancy = "";
		$(".DateTordOccupancy").each(function(){
			if($(this).is(":checked")){
				isOccupancy = $(this).val();
			}
		})
		var JDAMapping = "";
		$(".rdJDAMapping").each(function(){
			if($(this).is(":checked")){
				JDAMapping = $(this).val();
			}
		})
		if(isClassification == 0 && isDepartment == 0 && isCategory == 0){
			setTimeout(function(){
				showmodal("alert", "Please check atleast 1 unit referential.", "", null, "", null, "1");
			}, 500)
		}else{
			$.ajax({
				type: 'POST',
				url: 'setup/systemsetup/class.php',
				data: 'Setup1=' + Setup1 + '&Setup2=' + Setup2 + '&Setup3=' + Setup3 + '&Setup4=' + Setup4 + '&isClassification=' + isClassification + '&isDepartment=' + isDepartment + '&isCategory=' + isCategory + '&FlrUnit=' + FlrUnit + '&isAssocDues=' + isAssocDues + '&isMultiCompSig=' + isMultiCompSig + '&isOccupancy=' + isOccupancy + '&JDAMapping=' + JDAMapping + '&form=SaveLeaseSys',
				success: function(data){
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Leasing setup successfully saved.", "", null, "", null, "0");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", "Failed to save setup.", "", null, "", null, "1");
						}, 500)
					}
				}
			})
		}
	}

	function loadLeaseSys(){
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/class.php',
			data: 'form=loadLeaseSys',
			success: function(data){
				var arr = data.split("|");
				$(".rdRequirementandPermit").each(function(){
					if(arr[0] == $(this).val()){
						$(this).prop("checked", true);
					}
				})
				$(".rdAdjustOccupancy").each(function(){
					if(arr[1] == $(this).val()){
						$(this).prop("checked", true);
					}
				})
				$(".rdAutoMerchantCode").each(function(){
					if(arr[2] == $(this).val()){
						$(this).prop("checked", true);
					}
				})
				$("#slctFlrUnitMeasurement").val(arr[3]);
				$(".rdVatSetup").each(function(){
					if(arr[4] == $(this).val()){
						$(this).prop("checked", true);
					}
				})
				$(".isClassification").each(function(){
					if(arr[5] == 1){
						$(this).prop("checked", true);
					}else{
						$(this).prop("checked", false);
					}
				})
				$(".isDepartment").each(function(){
					if(arr[6] == 1){
						$(this).prop("checked", true);
					}else{
						$(this).prop("checked", false);
					}
				})
				$(".isCategory").each(function(){
					if(arr[7] == 1){
						$(this).prop("checked", true);
					}else{
						$(this).prop("checked", false);
					}
				})
				$(".rdAssocDues").each(function(){
					if(arr[8] == $(this).val()){
						$(this).prop("checked", true);
					}
				})
				$(".rdMultiCompSig").each(function(){
					if(arr[9] == $(this).val()){
						$(this).prop("checked", true);
					}
				})
				$(".DateTordOccupancy").each(function(){
					if(arr[10] == $(this).val()){
						$(this).prop("checked", true);
					}
				})
				$(".rdJDAMapping").each(function(){
					if(arr[11] == $(this).val()){
						$(this).prop("checked", true);
					}
				})
			}, complete: function(){
				$(".AlwaysCollapse").each(function(){
					var id = this.id;
					if($("#"+id +" i").hasClass("fa-chevron-up")){
						$("#"+id).click();
					}
				})
			}
		})
	}

	function fncSaveLPSetup(){
		var FirstBtn = $("#txtSetupLPFirstBtn").val();
		var SecondBtn = $("#txtSetupLPSecondBtn").val();
		var FontColor = $("#txtSetupLPFontColor").val();
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/class.php',
			data: 'FirstBtn=' + FirstBtn + '&SecondBtn=' + SecondBtn + '&FontColor=' + FontColor + '&form=fncSaveLPSetup',
			success: function(data){
				if(data == 1){
					setTimeout(function(){
						showmodal("alert", "Landing Page setup successfully saved.", "fncLoadLPSetup", null, "", null, "0");
					}, 500)
				}else{
					setTimeout(function(){
						showmodal("alert", "Failed to save setup.", "", null, "", null, "1");
					}, 500)
				}
			},
			complete: function(){
				var data = new FormData($('#frmLPBGImage')[0]);
				$.ajax({
					type: 'POST',
					url: 'setup/systemsetup/saveLPBGImage.php',
					data: data,
					mimeType: 'multipart/form-data',
					contentType: false,
					cache: false,
					processData: false,
					success: function(data){

					}
				});
			}
		})
	}

	function fncLoadLPSetup(){
		$.ajax({
			type: 'POST',
			url: 'setup/systemsetup/class.php',
			data: 'form=fncLoadLPSetup',
			success: function(data){
				var arr = data.split("|");
				$("#txtSetupLPFirstBtn").val(arr[0]);
				$("#txtSetupLPSecondBtn").val(arr[1]);
				$("#txtSetupLPFontColor").val(arr[2]);
			},
			complete: function(){
				$("#btnLPEdit").css("display", "block");
				$("#btnLPSave").css("display", "none");
				$("#btnLPCancel").css("display", "none");
				$(".txtSetupFields").prop("disabled", true);
			}
		})
	}

	function fncEditLPSetup(){
		$("#btnLPSave").css("display", "block");
		$("#btnLPCancel").css("display", "block");
		$("#btnLPEdit").css("display", "none");
		$(".txtSetupFields").prop("disabled", false);
	}

	function fncCancelLPSetup(){
		fncLoadLPSetup();
	}

	// function changeCSVHeader(){
	// 	var RefType = $("#CSVType").val();
	// 	if(RefType == "Charges"){
	// 		$("#tblCSVCharges").removeClass("hide");
	// 		$("#tblCSVPermits").addClass("hide");
	// 		$("#tblCSVRequirements").addClass("hide");
	// 		$("#tblCSVTermsAndCon").addClass("hide");
	// 		$("#tblCSVTenantProfile").addClass("hide");
	// 		$("#GeneratedCSVContent").html("");
	// 	}else if(RefType == "Permits"){
	// 		$("#tblCSVCharges").addClass("hide");
	// 		$("#tblCSVPermits").removeClass("hide");
	// 		$("#tblCSVRequirements").addClass("hide");
	// 		$("#tblCSVTermsAndCon").addClass("hide");
	// 		$("#tblCSVTenantProfile").addClass("hide");
	// 		$("#GeneratedCSVContent").html("");
	// 	}else if(RefType == "Requirements"){
	// 		$("#tblCSVCharges").addClass("hide");
	// 		$("#tblCSVPermits").addClass("hide");
	// 		$("#tblCSVRequirements").removeClass("hide");
	// 		$("#tblCSVTermsAndCon").addClass("hide");
	// 		$("#tblCSVTenantProfile").addClass("hide");
	// 		$("#GeneratedCSVContent").html("");
	// 	}else if(RefType == "TermsAndCon"){
	// 		$("#tblCSVCharges").addClass("hide");
	// 		$("#tblCSVPermits").addClass("hide");
	// 		$("#tblCSVRequirements").addClass("hide");
	// 		$("#tblCSVTermsAndCon").removeClass("hide");
	// 		$("#tblCSVTenantProfile").addClass("hide");
	// 		$("#GeneratedCSVContent").html("");
	// 	}else if(RefType == "TenantProfile"){
	// 		$("#tblCSVCharges").addClass("hide");
	// 		$("#tblCSVPermits").addClass("hide");
	// 		$("#tblCSVRequirements").addClass("hide");
	// 		$("#tblCSVTermsAndCon").addClass("hide");
	// 		$("#tblCSVTenantProfile").removeClass("hide");
	// 		$("#GeneratedCSVContent").html("");
	// 	}else{
	// 		$("#tblCSVCharges").removeClass("hide");
	// 		$("#tblCSVPermits").addClass("hide");
	// 		$("#tblCSVRequirements").addClass("hide");
	// 		$("#tblCSVTermsAndCon").addClass("hide");
	// 		$("#tblCSVTenantProfile").addClass("hide");
	// 		$("#GeneratedCSVContent").html("");
	// 	}x
	// }
	// MODIFIED BY PETER ( JANUARY 22, 2019 )
	// SELECTING REFERENTIAL
	function changeCSVHeader() {
		var RefType = $("#CSVType").val();

		$(".refTables").addClass("hide");

		if ( RefType == 'mallSetup' ) {
			$("#tblMall").removeClass("hide");
		}

		else if ( RefType == 'category' ) {
			$("#tblCategory").removeClass("hide");
		}

		else if ( RefType == 'classification' ) {
			$("#tblClassification").removeClass("hide");
		}

		else if ( RefType == 'wing' ) {
			$("#tblWing").removeClass("hide");
		}

		else if ( RefType == 'floorName' ) {
			$("#tblFloorName").removeClass("hide");
		}

		else if ( RefType == 'floorSetup' ) {
			$("#tblFloorSetup").removeClass("hide");
		}

		else if ( RefType == 'department' ) {
			$("#tblDepartment").removeClass("hide");
		}

		else if ( RefType == 'industry' ) {
			$("#tblIndustry").removeClass("hide");
		}

		else if ( RefType == 'amenities' ) {
			$("#tblAmenities").removeClass("hide");
		}

		else if ( RefType == 'unit' ) {
			$("#tblUnit").removeClass("hide");
		}

		else if ( RefType == 'company' ) {
			$("#tblCompany").removeClass("hide");
		}
	}
</script>