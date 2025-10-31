<script type="text/javascript">
$(function(){
    sayear();
})

setTimeout(function(){
    $(".fixTable").tableHeadFixer(); 
    $(".date-picker").datepicker({
        autoHide: true,
        format: 'dd',
        todayHighlight: true
    });
}, 500)

function sayear(){
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'form=sayear',
		success: function(data){
			$("#sayear").html(data);
		}
	})
}

function saday(){
	var month = $("#samonth").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'month=' + month + '&form=saday',
		success: function(data){
			$("#saday").html(data);
		}
	})
}

function company(){
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'year=' + year + '&month=' + month + '&day=' + day + '&form=companysales',
		beforeSend : function() {
	        $('#indexloadingscreen').addClass('myspinner');
	    },
	    success: function(data){
	        $('#indexloadingscreen').removeClass('myspinner');
			var arr = data.split("|");
			if(data == "1"){
		        showmodal("alert", "If you want to filter on a certain date you must also select month.", "", null, "", null, "0");
		  	}else{
		    	$("#dbsalesnanagaappend").html(arr[0]);
		    	$("#companynamelabel").text(arr[2]);
		    	$("#companyname").css("background-color", "#edf4f8");
		    	$("#companyname").css("color", "#2679B5");
		    	$("#companyname").css("display", "inherit");
		    	$("#mallname").css("display", "none");
				$("#wingname").css("display", "none");
				$("#floorname").css("display", "none");
				$("#unittypename").css("display", "none");
				$("#unitname").css("display", "none");
				$("#tenantname").css("display", "none");
				$("#monthname").css("display", "none");
				$("#dayname").css("display", "none");
				$("#mallenamelabel").text("Mall");
				$("#wingnamelabel").text("Wing");
				$("#floornamelabel").text("Floor");
				$("#unittypenamelabel").text("Unit Type");
				$("#unitnamelabel").text("Unit");
				$("#yearlysaleslabel").text("Tenant Sales By Year");
				$("#monthlysaleslabel").text("Tenant Sales By Month");
				$("#dailysaleslabel").text("");
		    }
		}
	})
}

function mallsales(){
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'year=' + year + '&month=' + month + '&day=' + day + '&form=mallsales',
		beforeSend : function() {
	        $('#indexloadingscreen').addClass('myspinner');
	    },
	    success: function(data){
	        $('#indexloadingscreen').removeClass('myspinner');
			var arr = data.split("|");
			$("#dbsalesnanagaappend").html(arr[0]);
			$("#companyname").css("background-color", "");
	    	$("#companyname").css("color", "");
	    	$("#mallenamelabel").css("background-color", "#edf4f8");
	    	$("#mallenamelabel").css("color", "#2679B5");
		    $("#mallname").css("display", "inherit");
		    $("#wingname").css("display", "none");
			$("#floorname").css("display", "none");
			$("#unittypename").css("display", "none");
			$("#unitname").css("display", "none");
			$("#tenantname").css("display", "none");
			$("#monthname").css("display", "none");
			$("#dayname").css("display", "none");
			$("#mallenamelabel").text("Mall");
			$("#wingnamelabel").text("Wing");
			$("#floornamelabel").text("Floor");
			$("#unittypenamelabel").text("Unit Type");
			$("#unitnamelabel").text("Unit");
			$("#yearlysaleslabel").text("Tenant Sales By Year");
			$("#monthlysaleslabel").text("Tenant Sales By Month");
			$("#dailysaleslabel").text("");
		}
	})
}

function wingsales(mallid){
	$("#mallid").val(mallid);
	var mallid = $("#mallid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'mallid=' + mallid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=wingsales',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
	        $('#indexloadingscreen').removeClass('myspinner');
			var arr = data.split("|");
			$("#dbsalesnanagaappend").html(arr[0]);
			$("#mallenamelabel").text(arr[1]);
			$("#mallenamelabel").css("background-color", "");
	    	$("#mallenamelabel").css("color", "");
	    	$("#wingnamelabel").css("background-color", "#edf4f8");
	    	$("#wingnamelabel").css("color", "#2679B5");
			$("#wingname").css("display", "inherit");
			$("#floorname").css("display", "none");
			$("#unittypename").css("display", "none");
			$("#unitname").css("display", "none");
			$("#tenantname").css("display", "none");
			$("#monthname").css("display", "none");
			$("#dayname").css("display", "none");
		}
	})
}

function wingsales2(){
	var mallid = $("#mallid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'mallid=' + mallid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=wingsales',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
			var arr = data.split("|");
			$("#dbsalesnanagaappend").html(arr[0]);
			$("#mallenamelabel").text(arr[1]);
			$("#mallenamelabel").css("background-color", "");
	    	$("#mallenamelabel").css("color", "");
	    	$("#wingnamelabel").css("background-color", "#edf4f8");
	    	$("#wingnamelabel").css("color", "#2679B5");
			$("#wingname").css("display", "inherit");
			$("#floorname").css("display", "none");
			$("#unittypename").css("display", "none");
			$("#unitname").css("display", "none");
			$("#tenantname").css("display", "none");
			$("#monthname").css("display", "none");
			$("#dayname").css("display", "none");
			$("#wingnamelabel").text("Wing");
			$("#floornamelabel").text("Floor");
			$("#unittypenamelabel").text("Unit Type");
			$("#unitnamelabel").text("Unit");
			$("#yearlysaleslabel").text("Tenant Sales By Year");
			$("#monthlysaleslabel").text("Tenant Sales By Month");
			$("#dailysaleslabel").text("");
		}
	})
}

function floorsales(wingid){
	$("#wingid").val(wingid);
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'mallid=' + mallid + '&wingid=' + wingid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=floorsales',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
			var arr = data.split("|");
			$("#dbsalesnanagaappend").html(arr[0]);
			$("#wingnamelabel").text(arr[1]);
			$("#wingnamelabel").css("background-color", "");
	    	$("#wingnamelabel").css("color", "");
	    	$("#floornamelabel").css("background-color", "#edf4f8");
	    	$("#floornamelabel").css("color", "#2679B5");
			$("#floorname").css("display", "inherit");
			$("#unittypename").css("display", "none");
			$("#unitname").css("display", "none");
			$("#tenantname").css("display", "none");
			$("#monthname").css("display", "none");
			$("#dayname").css("display", "none");
		}
	})
}

function floorsales2(){
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'mallid=' + mallid + '&wingid=' + wingid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=floorsales',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
		var arr = data.split("|");
		$("#dbsalesnanagaappend").html(arr[0]);
		$("#wingnamelabel").text(arr[1]);
		$("#wingnamelabel").css("background-color", "");
    	$("#wingnamelabel").css("color", "");
    	$("#floornamelabel").css("background-color", "#edf4f8");
    	$("#floornamelabel").css("color", "#2679B5");
		$("#floorname").css("display", "inherit");
		$("#unittypename").css("display", "none");
		$("#unitname").css("display", "none");
		$("#tenantname").css("display", "none");
		$("#monthname").css("display", "none");
		$("#dayname").css("display", "none");
		$("#floornamelabel").text("Floor");
		$("#unittypenamelabel").text("Unit Type");
		$("#unitnamelabel").text("Unit");
		$("#yearlysaleslabel").text("Tenant Sales By Year");
		$("#monthlysaleslabel").text("Tenant Sales By Month");
		$("#dailysaleslabel").text("");
		}
	})
}

function unittypesales(floorid){
	$("#floorid").val(floorid);
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var floorid = $("#floorid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'mallid=' + mallid + '&wingid=' + wingid + '&floorid=' + floorid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=unittypesales',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
		var arr = data.split("|");
		$("#dbsalesnanagaappend").html(arr[0]);
		$("#floornamelabel").text(arr[1]);
		$("#floornamelabel").css("background-color", "");
    	$("#floornamelabel").css("color", "");
    	$("#unittypenamelabel").css("background-color", "#edf4f8");
    	$("#unittypenamelabel").css("color", "#2679B5");
		$("#unittypename").css("display", "inherit");
		$("#unitname").css("display", "none");
		$("#tenantname").css("display", "none");
		$("#monthname").css("display", "none");
		$("#dayname").css("display", "none");
		}
	})
}

function unittypesales2(){
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var floorid = $("#floorid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'mallid=' + mallid + '&wingid=' + wingid + '&floorid=' + floorid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=unittypesales',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
		var arr = data.split("|");
		$("#dbsalesnanagaappend").html(arr[0]);
		$("#floornamelabel").text(arr[1]);
		$("#floornamelabel").css("background-color", "");
    	$("#floornamelabel").css("color", "");
    	$("#unittypenamelabel").css("background-color", "#edf4f8");
    	$("#unittypenamelabel").css("color", "#2679B5");
		$("#unittypename").css("display", "inherit");
		$("#unitname").css("display", "none");
		$("#tenantname").css("display", "none");
		$("#monthname").css("display", "none");
		$("#dayname").css("display", "none");
		$("#unittypenamelabel").text("Unit Type");
		$("#unitnamelabel").text("Unit");
		$("#yearlysaleslabel").text("Tenant Sales By Year");
		$("#monthlysaleslabel").text("Tenant Sales By Month");
		$("#dailysaleslabel").text("");
		}
	})
}

function unitsales(unittype){
	$("#unittype").val(unittype);
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var floorid = $("#floorid").val();
	var unittype = $("#unittype").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'mallid=' + mallid + '&wingid=' + wingid + '&unittype=' + unittype + '&floorid=' + floorid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=unitsales',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
		var arr = data.split("|");
		$("#dbsalesnanagaappend").html(arr[0]);
		$("#unittypenamelabel").text(arr[1]);
		$("#unittypenamelabel").css("background-color", "");
    	$("#unittypenamelabel").css("color", "");
    	$("#unitnamelabel").css("background-color", "#edf4f8");
    	$("#unitnamelabel").css("color", "#2679B5");
		$("#unitname").css("display", "inherit");
		$("#tenantname").css("display", "none");
		$("#monthname").css("display", "none");
		$("#dayname").css("display", "none");
		}
	})
}

function unitsales2(){
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var floorid = $("#floorid").val();
	var unittype = $("#unittype").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'mallid=' + mallid + '&wingid=' + wingid + '&unittype=' + unittype + '&floorid=' + floorid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=unitsales',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
		var arr = data.split("|");
		$("#dbsalesnanagaappend").html(arr[0]);
		$("#unittypenamelabel").text(arr[1]);
		$("#unittypenamelabel").css("background-color", "");
    	$("#unittypenamelabel").css("color", "");
    	$("#unitnamelabel").css("background-color", "#edf4f8");
    	$("#unitnamelabel").css("color", "#2679B5");
		$("#unitname").css("display", "inherit");
		$("#tenantname").css("display", "none");
		$("#monthname").css("display", "none");
		$("#dayname").css("display", "none");
		$("#unitnamelabel").text("Unit");
		$("#yearlysaleslabel").text("Tenant Sales By Year");
		$("#monthlysaleslabel").text("Tenant Sales By Month");
		$("#dailysaleslabel").text("");
		}
	})
}

function tenantsales(unitid){
	$("#unitid").val(unitid);
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var floorid = $("#floorid").val();
	var unitid = $("#unitid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'mallid=' + mallid + '&wingid=' + wingid + '&unittype=' + unittype + '&unitid=' + unitid + '&floorid=' + floorid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=tenantsales',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
		var arr = data.split("|");
		$("#dbsalesnanagaappend").html(arr[0]);
		$("#unitnamelabel").text(arr[1]);
		$("#unitnamelabel").css("background-color", "");
    	$("#unitnamelabel").css("color", "");
    	$("#yearlysaleslabel").css("background-color", "#edf4f8");
    	$("#yearlysaleslabel").css("color", "#2679B5");
		$("#tenantname").css("display", "inherit");
		$("#monthname").css("display", "none");
		$("#dayname").css("display", "none");
		}
	})
}

function tenantsales2(){
	var unittype = $("#unittype").val();
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var floorid = $("#floorid").val();
	var unitid = $("#unitid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'mallid=' + mallid + '&wingid=' + wingid + '&unittype=' + unittype + '&unitid=' + unitid + '&floorid=' + floorid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=tenantsales',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
		var arr = data.split("|");
		$("#dbsalesnanagaappend").html(arr[0]);
		$("#unitnamelabel").text(arr[1]);
		$("#unitnamelabel").css("background-color", "");
    	$("#unitnamelabel").css("color", "");
    	$("#yearlysaleslabel").css("background-color", "#edf4f8");
    	$("#yearlysaleslabel").css("color", "#2679B5");
		$("#tenantname").css("display", "inherit");
		$("#monthname").css("display", "none");
		$("#dayname").css("display", "none");
		$("#yearlysaleslabel").text("Tenant Sales By Year");
		$("#monthlysaleslabel").text("Tenant Sales By Month");
		$("#dailysaleslabel").text("");
		}
	})
}

function tenantsalesbymonth(tenantid){
	$("#tenantid").val(tenantid);
	var tenantid = $("#tenantid").val();
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var floorid = $("#floorid").val();
	var unitid = $("#unitid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	var unittype = $("#unittype").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'tenantid=' + tenantid + '&mallid=' + mallid + '&wingid=' + wingid + '&unittype=' + unittype + '&unitid=' + unitid + '&floorid=' + floorid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=tenantsalesbymonth',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
		var arr = data.split("|");
		$("#dbsalesnanagaappend").html(arr[0]);
		$("#yearlysaleslabel").text(arr[1]);
		$("#unitnamelabel").text(arr[2]);
		$("#yearlysaleslabel").css("background-color", "");
		$("#unitnamelabel").css("background-color", "");
    	$("#unitnamelabel").css("color", "");
    	$("#yearlysaleslabel").css("color", "");
    	$("#monthlysaleslabel").css("background-color", "#edf4f8");
    	$("#monthlysaleslabel").css("color", "#2679B5");
		$("#monthname").css("display", "inherit");
		$("#dayname").css("display", "none");
		}
	})
}

function tenantsales2bymonth(){
	var tenantid = $("#tenantid").val();
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var floorid = $("#floorid").val();
	var unitid = $("#unitid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	var unittype = $("#unittype").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'tenantid=' + tenantid + '&mallid=' + mallid + '&wingid=' + wingid + '&unittype=' + unittype + '&unitid=' + unitid + '&floorid=' + floorid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=tenantsalesbymonth',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
		var arr = data.split("|");
		$("#dbsalesnanagaappend").html(arr[0]);
		$("#yearlysaleslabel").text(arr[1]);
		$("#yearlysaleslabel").css("background-color", "");
    	$("#yearlysaleslabel").css("color", "");
    	$("#monthlysaleslabel").css("background-color", "#edf4f8");
    	$("#monthlysaleslabel").css("color", "#2679B5");
		$("#monthname").css("display", "inherit");
		$("#dayname").css("display", "none");
		$("#monthlysaleslabel").text("Tenant Sales By Month");
		$("#dailysaleslabel").text("");
		}
	})
}

function tenantsalesbyday(tenantmonth, tenantid){
	$("#tenantmonth").val(tenantmonth);
	$("#tenantid").val(tenantid);
	var tenantid = $("#tenantid").val();
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var floorid = $("#floorid").val();
	var unitid = $("#unitid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	var tenantmonth = $("#tenantmonth").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'tenantmonth=' + tenantmonth + '&tenantid=' + tenantid + '&mallid=' + mallid + '&wingid=' + wingid + '&unittype=' + unittype + '&unitid=' + unitid + '&floorid=' + floorid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=tenantsalesbyday',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
			var arr = data.split("|");
			$("#dbsalesnanagaappend").html(arr[0]);
			$("#monthlysaleslabel").text(arr[1]);
			$("#dailysaleslabel").text(arr[2]);
			$("#monthlysaleslabel").css("background-color", "");
	    	$("#monthlysaleslabel").css("color", "");
	    	$("#dailysaleslabel").css("background-color", "#edf4f8");
	    	$("#dailysaleslabel").css("color", "#2679B5");
			$("#dayname").css("display", "inherit");
		}
	})
}

function tenantsales2byday(){
	var tenantid = $("#tenantid").val();
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var floorid = $("#floorid").val();
	var unitid = $("#unitid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	var tenantmonth = $("#tenantmonth").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'tenantmonth=' + tenantmonth + '&tenantid=' + tenantid + '&mallid=' + mallid + '&wingid=' + wingid + '&unittype=' + unittype + '&unitid=' + unitid + '&floorid=' + floorid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=tenantsalesbyday',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
			var arr = data.split("|");
			$("#dbsalesnanagaappend").html(arr[0]);
			$("#monthlysaleslabel").text(arr[1]);
			$("#monthlysaleslabel").css("background-color", "");
	    	$("#monthlysaleslabel").css("color", "");
	    	$("#dailysaleslabel").css("background-color", "#edf4f8");
	    	$("#dailysaleslabel").css("color", "#2679B5");
			$("#dayname").css("display", "inherit");
		}
	})
}

function tenantsalesbyday3(){
	var unitid = $("#unitid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	var mallid = $("#mallid").val();
	var wingid = $("#wingid").val();
	var floorid = $("#floorid").val();
	var unittype = $("#unittype").val();
	$.ajax({
		type: 'POST',
		url: 'reports/salesaudit/class.php',
		data: 'unittype=' + unittype + '&mallid=' + mallid + '&wingid=' + wingid + '&floorid=' + floorid + '&unitid=' + unitid + '&year=' + year + '&month=' + month + '&day=' + day + '&form=tenantsalesbyday3',
		beforeSend : function() {
            $('#indexloadingscreen').addClass('myspinner');
        },
        success: function(data){
            $('#indexloadingscreen').removeClass('myspinner');
			var arr = data.split("|");
			$("#dbsalesnanagaappend").html(arr[0]);
			$("#dailysaleslabel").text(arr[1]);
			$("#unitnamelabel").text(arr[2]);
			$("#unitnamelabel").css("background-color", "");
	    	$("#unitnamelabel").css("color", "");
			$("#monthlysaleslabel").css("background-color", "");
	    	$("#monthlysaleslabel").css("color", "");
	    	$("#dailysaleslabel").css("background-color", "#edf4f8");
	    	$("#dailysaleslabel").css("color", "#2679B5");
			$("#dayname").css("display", "inherit");
		}
	})
}

function checkfilterofdate(unitid){
	$("#unitid").val(unitid)
	var unitid = $("#unitid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	if(month != "" && day != ""){
		tenantsalesbyday3();
	}
	else if(month != "" && day == ""){
		tenantsalesbymonth();
	}
	else if(month == "" && day == ""){
		tenantsales2();
	}
}

function checkfilterofdate2(){
	var unitid = $("#unitid").val();
	var year = $("#sayear").val();
	var month = $("#samonth").val();
	var day = $("#saday").val();
	if(month != "" && day != ""){
		tenantsalesbyday3();
	}
	else if(month != "" && day == ""){
		tenantsales2bymonth();
	}
	else if(month == "" && day == ""){
		tenantsales2();
	}
}
</script>