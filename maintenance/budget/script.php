<script type="text/javascript">
	$(function(){
	    $(".fixTable").tableHeadFixer(); 
	    getRefMall();
	    showtypeofbudget();
	})


	function getRefMall(){
		$.ajax({
			type: 'POST',
			url: 'mainclass.php',
			data: 'form=tblref_mall',
			success:function(data){
				$('#selMall').html(data);
			    tblbudget();
			}
		});
	}

	function tblbudget(){
		var type = $("#typeofbudget").val();
		var mall = $("#selMall").val();
		var year = $("#budgetyear").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/budget/class.php',
			data: 'type=' + type + '&mall=' + mall + '&year=' + year + '&form=tblbudget',
			success:function(data){
				$("#tblbudget").html(data);
			}
		})
	}

	function showtypeofbudget(){
		$.ajax({
			type: 'POST',
			url: 'maintenance/budget/class.php',
			data: 'form=showtypeofbudget',
			success:function(data){
				$("#typeofbudget").html(data);
			}
		})
	}
	
	function addbudgetperyear(){
		var year = $("#budgetyear").val();
		var utility = $("#typeofbudget").val();
		var mall = $("#selMall").val();
		if(mall != ""){
			if(year != ""){
				if(utility != ""){
					$("#modalforaddingbudget").modal("show");
					$.ajax({
						type: 'POST',
						url: 'maintenance/budget/class.php',
						data: 'year=' + year + '&utility=' + utility + '&mall=' + mall + '&form=addbudgetperyear',
						success:function(data){
							var arr = data.split("|");
							$("#labelformodalofaddingbudget").text(arr[0]+" budget for the year of "+year);
							$("#xjan").val(arr[1]);
							$("#xfeb").val(arr[2]);
							$("#xmar").val(arr[3]);
							$("#xapr").val(arr[4]);
							$("#xmay").val(arr[5]);
							$("#xjun").val(arr[6]);
							$("#xjul").val(arr[7]);
							$("#xaug").val(arr[8]);
							$("#xsep").val(arr[9]);
							$("#xoct").val(arr[10]);
							$("#xnov").val(arr[11]);
							$("#xdec").val(arr[12]);
						}
					})
				}else{
					showmodal("alert", "Please select utility.", "", null, "", null, "0");
				}
			}else{
				showmodal("alert", "Please select year.", "", null, "", null, "0");
			}
		}else {
			showmodal("alert", "Please select Mall.", "", null, "", null, "0");
		}
	}

	function savebudgetperyear(){
		var year = $("#budgetyear").val();
		var utility = $("#typeofbudget").val();
		var mall = $("#selMall").val();
		var xjan = $("#xjan").val();
		var xfeb = $("#xfeb").val();
		var xmar = $("#xmar").val();
		var xapr = $("#xapr").val();
		var xmay = $("#xmay").val();
		var xjun = $("#xjun").val();
		var xjul = $("#xjul").val();
		var xaug = $("#xaug").val();
		var xsep = $("#xsep").val();
		var xoct = $("#xoct").val();
		var xnov = $("#xnov").val();
		var xdec = $("#xdec").val();
		$.ajax({
			type: 'POST',
			url: 'maintenance/budget/class.php',
			data: 'year=' + year + '&xjan=' + xjan + '&xfeb=' + xfeb + '&xmar=' + xmar + '&xapr=' + xapr + '&xmay=' + xmay + '&xjun=' + xjun + '&xjul=' + xjul + '&xaug=' + xaug + '&xsep=' + xsep + '&xoct=' + xoct + '&xnov=' + xnov + '&xdec=' + xdec + '&utility=' + utility + '&mall=' + mall + '&form=savebudgetperyear',
			success:function(data){
				var arr = data.split("|");
				showmodal("alert", arr[0]+" budget for the year of "+arr[1]+" has been "+arr[2]+".", "tblbudget", null, "", null, "0");
				$("#modalforaddingbudget").modal("hide");
			}
		})
	}
</script>