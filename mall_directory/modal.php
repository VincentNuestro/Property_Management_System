<script>
	function showmodal(type, text, btnfunction1, params1, btnfunction2, params2, alerticon) {
		if(type == "alert") {
			if(alerticon == "1")
			{ $("#modaltype").html("<span class='fa fa-exclamation-triangle red'></span>&nbsp;&nbsp;Alert"); }
			else
			{ $("#modaltype").html("<span class='fa fa-info-circle' style='color: #06F;'></span>&nbsp;&nbsp;Information"); }
		}
		else if(type == "confirm") { 
			$("#modaltype").html("<span class='fa fa-info-circle' style='color: #06F;'></span>&nbsp;&nbsp;Confirm"); 
		}
		else { 
			$("#modaltype").html("<span class='fa fa-bookmark' style='color: #87B87F;'></span>&nbsp;&nbsp;Prompt");
		}

		$("#modaltxt").text(text);
		var btnpadd = "";
		var btntxt = "";
		
		if(type == "alert") {
			btntxt = "OK";
			$("#txtinput").css("display", "none");
		}

		else if ( type == "confirm" ) {
			btntxt = "Yes";
			$("#txtinput").css("display", "none");
		}

		else {
			btntxt = "SUBMIT";
			$("#txtinput").css("display", "inline-block");
		}
		
		// 1st Button
		var f1 = "";
		var p1 = "";
		if(btnfunction1 != "") {
			if(params1 != null) {
				for(var i=0; i<=params1.length-1; i++) { 
					p1 += ", \"" + params1[i] + "\""; 
				}
			}
			f1 = btnfunction1 + "(" + p1.substr(2) + ");";
			btnpadd += "<button class='btn btn-success btn-sm' onclick='" + f1 + " $(\"#alertmodal\").modal(\"hide\");'><span class='glyphicon glyphicon-ok'></span>&nbsp;&nbsp;" + btntxt + "</button>";
		}
		else
		{ btnpadd += "<button class='btn btn-success btn-sm' onclick='$(\"#alertmodal\").modal(\"hide\");'><span class='glyphicon glyphicon-ok'></span>&nbsp;&nbsp;OK</button>"; }
		
		if(type != "alert") {
			// 2nd Button
			var f2 = "";
			var p2 = "";
			if(btnfunction2 != "")
			{
				if(params2 != null)
				{
					for(var j=0; j<=params2.length-1; j++)
					{ p2 += ", \"" + params2[j] + "\""; }
				}
				f2 = btnfunction2 + "(" + p2.substr(2) + ");";
				btnpadd += "<button class='btn btn-danger btn-sm' onclick='" + f2 + " $(\"#alertmodal\").modal(\"hide\");'><span class='glyphicon glyphicon-remove'></span>&nbsp;&nbsp;CANCEL</button>";
			}
			else
			{ btnpadd += "<button class='btn btn-danger btn-sm' onclick='$(\"#alertmodal\").modal(\"hide\");'><span class='glyphicon glyphicon-remove'></span>&nbsp;&nbsp;CANCEL</button>"; }
		}
		
		$("#modalbtn").html("<center>" + btnpadd + "</center>");
		$("#alertmodal").modal("show");
	}
</script>
<style>
	.atitle
	{
		font-size: 14px;
		font-weight: 400;
		color: #666;
		margin: 0px;
	}
	
	.modaltxt
	{
		font-size: 16px;
		font-weight: 400;
		color: #666;
		text-align: center;
		margin: 10px;
	}
</style>
<div class="modal fade fade-scale" id="alertmodal" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: white !important;">
				<h6 class="atitle" id="modaltype"></h6>
			</div>
			<div class="modal-body">
				<h3 class="modaltxt" id="modaltxt"></h3>
				<input type="text" class="form-control" id="txtinput" style="margin: 0px auto;">
			</div>
			<div class="modal-footer" id="modalbtn">
			</div>
		</div>
	</div>
</div>