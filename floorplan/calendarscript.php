<?php
	$weeks = array("", "MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN");
	$months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
?>
<script type="text/javascript">
	var unitnum = $("#unitlist td").length;
	var active = "week";
	var units = "";
	var loopcells;
	var totalcells = 0;
	var num = 0;
	
	$(function(){
		$("#unitlist tr").each(function(){
			units += "|" + $(this).attr("id");
		});
		weeknav("today");
		$(".unitlist").niceScroll({ cursorcolor: "#666", cursorwidth: "8px" });
		$(".tenants").niceScroll({ cursorcolor: "#666", cursorwidth: "8px" });
		$("#unitlist0").on('scroll', function () {
			$("#unitlist1").scrollTop($(this).scrollTop());
			$("#unitlist2").scrollTop($(this).scrollTop());
			$("#unitlist3").scrollTop($(this).scrollTop());
		});
		$("#viewlist label").each(function(){
			var obj = $(this);
			obj.click(function(){
				$("#viewlist label").removeClass("btn-success");
				$("#viewlist label").addClass("btn-grey");
				obj.removeClass("btn-grey");
				obj.addClass("btn-success");
				$("#viewlist label").removeClass("active");
				obj.addClass("active");
				$(".views").css("display", "none");
				$("#" + obj.attr("id") + "view").css("display", "block");
				$(".pull-right .btn-group").css("display", "none");
				$("#btn-" + obj.attr("id")).css("display", "block");
				clearInterval(loopcells);
				if(obj.attr("id") == "week"){
					active = "week";
					weeknav("today");
				}else if(obj.attr("id") == "month"){
					active = "month";
					monthnav("today");
				}else{
					active = "year";
					yearnav("today");
				}
			});
		});
	});
	
	function addzero(n){
		var str = "";
		if(n < 10){ 
			str = "0" + n; 
		}else{ 
			str = n;
		}
		return str;
	}
	
	function weeknav(str){
		var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		var weeks = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];
		var datelist = "";
		var datelist1 = "";
		var datelist2 = "";
		var mydate = new Date();
		var dpadding1 = "";
		var dpadding2 = "";
		var adder = 24*60*60*1000;
		var multiplier = parseInt($("#txtcnt").val());
		if(str == "prev"){
			multiplier = multiplier - 1;
			mydate = new Date(mydate.getTime() + (7*multiplier) * adder);
		}else if(str == "next"){
			multiplier = multiplier + 1;
			mydate = new Date(mydate.getTime() + (7*multiplier) * adder);
		}else{
		 	mydate = new Date(); 
		}
		var dayofweek = mydate.getDay()
		for(var i=1; i<=6-dayofweek; i++){
			var mydate2 = new Date(mydate.getTime() + i * adder);
			datelist2 += "|" + mydate2.getFullYear() + "-" + addzero(mydate2.getMonth()+1) + "-" + addzero(mydate2.getDate());
			dpadding1 += "<th width='140px' valign='top' style='height: 60px;'><h3 style='margin: 0px;'>" + weeks[mydate2.getDay()] + " <small style='display: block; font-size: 13px; margin-top: 5px;'>" + months[mydate2.getMonth()] + " " + mydate2.getDate() + "</small></h3></th>";
		}
		for(var j=dayofweek; j>=1; j--){
			var mydate2 = new Date(mydate.getTime() - j * adder);
			datelist1 += "|" + mydate2.getFullYear() + "-" + addzero(mydate2.getMonth()+1) + "-" + addzero(mydate2.getDate());
			dpadding2 += "<th width='140px' valign='top' style='height: 60px;'><h3 style='margin: 0px;'>" + weeks[mydate2.getDay()] + " <small style='display: block; font-size: 13px; margin-top: 5px;'>" + months[mydate2.getMonth()] + " " + mydate2.getDate() + "</small></h3></th>";
		}
		datelist = datelist1 + "|" + mydate.getFullYear() + "-" + addzero(mydate.getMonth()+1) + "-" + addzero(mydate.getDate()) + datelist2;
		$("#weekcont1").html("<tr>" + dpadding2 + "<th width='140px' valign='top' style='height: 60px;'><h3 style='margin: 0px;'>" + weeks[mydate.getDay()] + " <small style='display: block; font-size: 13px; margin-top: 5px;'>" + months[mydate.getMonth()] + " " + mydate.getDate() + "</small></h3></th>" + dpadding1 + "</tr>");
		$("#weekcont2").html("");
		
		var arr = units.split("|");
		for(var x=1; x<=unitnum; x++){
			var arr2 = datelist.split("|");
			var padding2 = "";
			for(var y=1; y<=7; y++){ 
				padding2 += "<td width='140px' style='height: 100px;' id='" + arr[x] + "_" + arr2[y] + "'><div class='bills'></div></td>"; 
			}
			$("#weekcont2").append("<tr>" + padding2 + "</tr>");
		}
		$("#txtcnt").val(multiplier);
		loaddetails("#weekcont2", "1");
	}
	
	function monthnav(str){
		var month = parseInt($("#txtmonth").val());
		var year = parseInt($("#txtyear").val());
		var datelist = "";
		if(str == "prev"){
			month = month - 1;
			if(month == -1){
				year = year - 1;
				month = 11;
			}
		}else if(str == "next"){
			month = month + 1;
			if(month == 12){
				year = year + 1;
				month = 0;
			}
		}else{
			month = <?php echo date("m")-1; ?>;
			year = <?php echo date("Y"); ?>;
		}
		$("#txtmonth").val(month);
		$("#txtyear").val(year);
		var totalfeb;
		if(month == 1){  
			if((year%100!=0) && (year%4==0) || (year%400==0)){ 
				totalfeb = 29; 
			}else{ 
				totalfeb = 28; 
			}
		}
		var totaldays = [31, totalfeb, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
		var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		var weeks = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];
		var padding = "";
		for(var i=1; i<=totaldays[month]; i++){
			var mydate = new Date(year, month, i);
			datelist += "|" + mydate.getFullYear() + "-" + addzero(mydate.getMonth()+1) + "-" + addzero(mydate.getDate());
			padding += "<th width='160px' valign='top' style='height: 60px;'><h3 style='margin: 0px;'>" + weeks[mydate.getDay()] + " <small style='display: block; font-size: 13px; margin-top: 5px;'>" + months[month] + " " + i + ", " + year + "</small></h3></th>";
		}
		$("#monthcont1").html("<tr>" + padding + "</tr>");
		$("#monthcont2").html("");
		$("#unitlist2").width(totaldays[month]*160);
		$("#monthcont0_1").width(totaldays[month]*160);
		$("#monthcont0_2").width(totaldays[month]*160);
		var arr = units.split("|");
		for(var x=1; x<=unitnum; x++){
			var padding2 = "";
			var arr2 = datelist.split("|");
			for(var y=1; y<=totaldays[month]; y++){ 
				padding2 += "<td width='160px' valign='top' style='height: 100px;' id='" + arr[x] + "_" + arr2[y] + "'><div class='bills'></div></td>"; 
			}
			$("#monthcont2").append("<tr>" + padding2 + "</tr>");
		}
		loaddetails("#monthcont2", "1");
	}
	
	function yearnav(str){
		var months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		var year = parseInt($("#txtyear2").val());
		if(str == "prev"){ 
			year = year - 1; 
		}else if(str == "next"){ 
			year = year + 1; 
		}else{ 
			year = <?php echo date("Y"); ?>; 
		}
		$("#txtyear2").val(year);
		$("#yearcont1").html("");
		var padding = "";
		for(var i=1; i<=12; i++){ 
			padding += "<th width='200px' valign='top' style='height: 60px;'><h3 style='margin: 0px;'>" + months[i] + " <small style='display: block; font-size: 12px; margin-top: 5px;'>" + year + "</small></h3></th>"; 
		}
		$("#yearcont1").html("<tr>" + padding + "</tr>");
		$("#yearcont2").html("");
		var arr = units.split("|");
		for(var x=1; x<=unitnum; x++){
			var padding2 = "";
			for(var y=1; y<=12; y++){
				padding2 += "<td width='160px' valign='top' style='height: 100px;' id='" + arr[x] + "_" + y + "-" + year + "'><div class='tenants' style='height: 80px;'></div></td>"; 
			}
			$("#yearcont2").append("<tr>" + padding2 + "</tr>");
		}
		loaddetails("#yearcont2", "0");
	}
	
	function getcolor(stat){
		var myclass = "";
		switch(stat){
			case "vacant": myclass = "label-light"; break;
			case "reserved": myclass = "label-warning"; break;
			case "occupied": myclass = "label-yellow"; break;
			case "maintenance": myclass = "label-purple"; break;
			case "renewal": myclass = "label-info"; break;
			case "for eviction": myclass = "label-danger"; break;
			case "late payment": myclass = "label-grey"; break;
			default: myclass = "label-light";
		}
		return myclass;
	}
	
	function loaddetails(cont, type){
		num = 0;
		totalcells = $(cont).find("td").length;
		loopcells = setInterval(function(){
			if(type == "1"){ 
				loaddetails2($(cont).find("td").eq(num).attr("id"), cont); 
			}else{ 
				loaddetails3($(cont).find("td").eq(num).attr("id"), cont); 
			}
			if(num == totalcells){ 
				clearInterval(loopcells); 
			}else{ 
				num++; 
			}
		}, 500);
	}
	
	function loaddetails2(id, cont){
		var obj = $(cont).find("#" + id);
		var arrc = id.split("_");
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'unitid=' + arrc[0] + '&mydate=' + arrc[1] + '&form=getdetails',
			beforeSend:function(){
				obj.find(".bills").html("<img class='myspinner' src='assets/images/spinner2.gif'>");
			},
			success: function(data) {
				obj.find(".bills").find(".myspinner").remove();
				var arr = data.split("|");
				obj.addClass(getcolor(arr[6]));
				if(arr[1] != ""){ 
					obj.find(".bills").append("<a class='ellipsis' href='#' onclick='viewtenantdetails(\"" + arr[1] + "\", \"" + arrc[0] + "\");'>" + arr[2] + "</a>"); 
				}
				if(arr[3] == "1"){
				obj.find(".bills").append("<span class='btn btn-yellow btn-xs' style='margin: 2px;'>&nbsp;<i class='ace-icon fa fa-bolt bigger-110 icon-only'></i>&nbsp;</span>"); 
				}
				if(arr[4] == "1"){ 
					obj.find(".bills").append("<span class='btn btn-info btn-xs' style='margin: 2px;'><i class='ace-icon glyphicon glyphicon-tint bigger-110 icon-only'></i></span>"); 
				}
				if(arr[5] == "1"){ 
					obj.find(".bills").append("<span class='btn btn-grey btn-xs' style='margin: 2px;'><i class='ace-icon glyphicon glyphicon-file bigger-110 icon-only'></i></span>"); 
				}
			}
		})
	}
	
	function loaddetails3(id, cont){
		var obj = $(cont).find("#" + id);
		var arrc = id.split("_");
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'unitid=' + arrc[0] + '&mydate=' + arrc[1] + '&form=getdetails2',
			beforeSend:function(){
				obj.find(".tenants").html("<img class='myspinner' src='assets/images/spinner2.gif'>");
			},
			success: function(data) {
				obj.find(".tenants").find(".myspinner").remove();
				var arr = data.split("#");
				for(var i=1; i<=arr.length-1; i++){
					var arr2 = arr[i].split("|");
					if(arr2[1] != ""){ 
						obj.find(".tenants").append("<button class='btn btn-xs btn-primary'>" + arr2[2] + "&nbsp;&nbsp;<span class='glyphicon glyphicon-menu-hamburger' onclick='viewtenantdetails(\"" + arr2[1] + "\", \"" + arrc[0] + "\");' style='cursor: pointer;'></span></button>"); 
					}
				}
			}
		})
	}
	
	function loadwing(mallid){
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'mallid=' + mallid + '&form=loadwing',
			beforeSend:function(){
			},
			success: function(data) {
				$("#txtwing").html(data);
				loadfloor($("#txtwing option:first-child").val());
			}
		})
	}
	
	function loadfloor(wingid){
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'wingid=' + wingid + '&form=loadfloor',
			beforeSend:function(){
			},
			success: function(data) {
				$("#txtfloor").html(data);
			}
		})
	}
	
	function filterunit(){
		var mallid = $("#txtmall").val();
		var wingid = $("#txtwing").val();
		var floorid = $("#txtfloor").val();
		var type = "";
		$(".txtunittype").each(function(){
			if($(this).is(":checked") == true)
			{ type = $(this).val(); }
		});
		var key = $("#txtsearchunit").val();
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'mallid=' + mallid + '&wingid=' + wingid + '&floorid=' + floorid + '&type=' + type + '&key=' + key + '&form=filterunit',
			beforeSend:function(){
			},
			success: function(data) {
				$("#unitlist").html(data);
				unitnum = $("#unitlist td").length;
				units = "";
				$("#unitlist tr").each(function(){
					units += "|" + $(this).attr("id");
				});
				clearInterval(loopcells);
				if(active == "week"){ 
					weeknav("today"); 
				}else if(active == "week"){ 
					monthnav("today"); 
				}else{ 
					yearnav("today"); 
				}
			}
		})
	}
	
	function viewtenantdetails(tenantid, unitid){
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			data: 'tenantid=' + tenantid + '&unitid=' + unitid + '&form=tenantdetails',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				$("#ltenantname").text(arr[1]);
				$("#lindustry").text(arr[2]);
				$("#lunitname").text(arr[3]);
				$("#lmall").text(arr[4]);
				$("#lwing").text(arr[5]);
				$("#lfloor").text(arr[6]);
				$("#lstartdate").text(arr[7]);
				$("#lenddate").text(arr[8]);
				$("#viewtenant").modal("show");
			}
		})
	}
	
	function addcellclick(cont){
		$(cont).find("td").each(function(){
			var obj = $(this);
			var id = obj.attr("id");
			var arr = id.split("_");
			obj.click(function(){
				if(getunittype(arr[0])[3] == "SET"){
					$("#div_main_cont").load("tenants/floorplan2.php", { "mallid": getunittype(arr[0])[0], "wingid": getunittype(arr[0])[1], "floorid": getunittype(arr[0])[2], "unitid": arr[0], "mydate": arr[1] });
					$("#li_header_header a").text("SET");
				}else{
					$("#div_main_cont").load("tenants/floorplan3.php", { "mallid": getunittype(arr[0])[0], "wingid": getunittype(arr[0])[1], "floorid": getunittype(arr[0])[2], "unitid": arr[0], "mydate": arr[1] });
					$("#li_header_header a").text("LCA - Leasable Common Area");
				}
			});
		});
	}
	
	function getunittype(unitid){
		var mytype = [];
		$.ajax({
			type: 'POST',
			url: 'floorplan/mcp_mainclass.php',
			async: false,
			data: 'unitid=' + unitid + '&form=getunittype',
			beforeSend:function(){
			},
			success: function(data) {
				var arr = data.split("|");
				mytype.push(arr[1]);
				mytype.push(arr[2]);
				mytype.push(arr[3]);
				mytype.push(arr[4]);
			}
		})
		return mytype;
	}
</script>