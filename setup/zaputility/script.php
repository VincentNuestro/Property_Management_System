<script type="text/javascript">
	$(function(){
		$("#chkSelectAllZap").click(function(){
			if($(this).is(":checked")){
				$(".chkAllZap").prop("checked", true);
			}else{
				$(".chkAllZap").prop("checked", false);
			}
		})
	})

	function fncProceedTruncate(){
		var Count = 0;
		var Checked = "";
		$(".chkAllZap").each(function(){
			if($(this).is(":checked")){
				Checked += $(this).attr("id") + "|";
				Count++;
			}
		})
		if(Count > 0){
			$.ajax({
				type: 'POST',
				url: 'setup/zaputility/class.php',
				data: 'Checked=' + Checked + '&form=fncProceedTruncate',
				beforeSend: function(){
               	 	$('#indexloadingscreen').addClass('myspinner');
				},
				success: function(data){
                	$('#indexloadingscreen').removeClass('myspinner');
					if(data == 1){
						setTimeout(function(){
							showmodal("alert", "Selected data successfully truncated.", "", null, "", null, "0");
						}, 500)
					}else{
						setTimeout(function(){
							showmodal("alert", "Failed to truncate data on selected data.", "", null, "", null, "1");
						}, 500)
					}
				}
			})
		}else{
			setTimeout(function(){
				showmodal("alert", "Please select the data you want to truncate.", "", null, "", null, "1");
			}, 500)
		}
	}
</script>