<?php 
	if ( $_GET['url'] == 'eventsmod' && $_GET['type'] == 'vieweventscalendar') { 
		include('events/calendar/index.php');
	}elseif ( $_GET['url'] == 'eventsmod' && $_GET['type'] == 'vieweventslist') {
		include('events/eventslist/index.php');
	}

?>