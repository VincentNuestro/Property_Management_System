<script type="text/javascript">
	$(function(){
		loadCalendar('', '<?php echo date('Y-m-d'); ?>');
	})

	function loadCalendar(petsa, petsa2) {
		if ( petsa == "" ) {
			var petsa = "<?php echo date('Y-m-d'); ?>";	
		}

		$.ajax ({
			type: 'POST',
			url: 'events/calendar/calendar.php',
			data: 'petsa=' + petsa + '&petsa2=' + petsa2 + '&form=loadCalendar',
			success: function(data) {
				$("#calendar2").html(data);
			}
		})
	}

	function openCreateEvent() {
		$("#mdlEvent").modal("show");
	}
</script>