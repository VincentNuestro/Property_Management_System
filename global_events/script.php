<script type="text/javascript">
	$(function(){

		$('[data-rel=popover]').popover({html:true});
		collapseIcon();
		numbers();
		datePickers();
		showEvents();
	})

	function datePickers() {
		$(".date-picker").datepicker({
			autoHide: true,
			format: 'mm/dd/yyyy',
			todayHighlight: true
		});

		
	}

	$(document).bind('keydown', function(e) {
		if(e.ctrlKey && (e.which == 83)) {
			e.preventDefault();
			// alert('Ctrl+S');
			return false;
		}
	});


	function showEvents() {
		$(".eventNavs li").each(function(){
			$(this).click(function(){
				$(".eventNavsli").removeClass('active');
				$(this).addClass('active');

				var eventBody = $(this).find("a").prop("name");
				$(".eventorder").addClass("hide");
				$("#"+eventBody).removeClass("hide");
			})
		})
	}


	function numbers() {
		$(".numberlang").keydown(function (e) {
		// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
			// Allow: Ctrl+A, Command+A
			(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
			// Allow: home, end, left, right, down, up
			(e.keyCode >= 35 && e.keyCode <= 40)) {
			// let it happen, don't do anything
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
	}
	// DAY TO DAY ACTIVITY (END)

	// FUNCTION FOR THE ICON OF COLLAPSE
	function collapseIcon() {
		setTimeout(function(){
			$(".collapsebtn").each(function(){
				var eto = $(this)
				eto.click(function(){
					if ( eto.hasClass("collapsed") ) {
						eto.find(".collapse-icon").css({
							"transform":"rotate(180deg)",
							"transition": "0.3s"
						});
					} else {
						eto.find(".collapse-icon").css({
							"transform":"rotate(0deg)",
							"transition": "0.3s"
						});
					}
				})
			})
		}, 1000)
	}


	



</script>

<?php include('script2.php'); ?>