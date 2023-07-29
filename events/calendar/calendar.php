<?php
	include "../../connect.php";

	switch ($_POST['form']) {
		case 'loadCalendar':


			?>
				<div class="container-fluid">
					<table border="1" width="100%" class="calendarTable table" cellspacing="0">
						<thead>
							<th colspan="7" class="calendarHeader">
								<div class="btn-group col-md-4">
									<button style="background: #870000;" class="btn btn-warning" onclick="loadCalendar('<?php echo date('Y-m-d', strtotime($_POST['petsa'] . ' last month')); ?>', '<?php echo date('Y-m-d') ?>')"><span class="fa fa-fast-backward" style="font-size: 20px;"></span></button>
									<button class="btn btn-gray" onclick="loadCalendar('', '<?php echo date('Y-m-d') ?>')">Today</button>
									<button style="background: #870000;" class="btn btn-warning" onclick="loadCalendar('<?php echo date('Y-m-d', strtotime($_POST['petsa'] . 'next month')); ?>', '<?php echo date('Y-m-d') ?>')"><span class="fa fa-fast-forward" style="font-size: 20px;"></span></button>
								</div>

								<div class="col-md-4" style="text-align: center !important;">
									<span style="font-size: 20px;"><?php echo date('F Y', strtotime($_POST['petsa'])); ?></span>
								</div>

								<div class="col-md-4">
<!-- 									<button class="btn btn-warning pull-right" onclick="openCreateEvent()"><span class="fa fa-plus"></span> CREATE EVENT</button> -->
								</div>
							</th>
						</thead>
						<thead class="headDays">
							<th style="text-align: center !important;" width="14%">Sunday</th>
							<th style="text-align: center !important;" width="14%">Monday</th>
							<th style="text-align: center !important;" width="14%">Tuesday</th>
							<th style="text-align: center !important;" width="14%">Wednesday</th>
							<th style="text-align: center !important;" width="14%">Thursday</th>
							<th style="text-align: center !important;" width="14%">Friday</th>
							<th style="text-align: center !important;" width="14%">Saturday</th>
						</thead>

						<tbody class="calendar2">
							<?php
								$countWeek = 1;
								$countWeek2 =1;
								for ( $a = 1; $a <= 6; $a++ ) {
									?>
										<tr>
											<?php
												for ( $b = 0; $b <= 6; $b++ ) {
													$currentDate = date('Y-m', strtotime($_POST['petsa'])) . "-" . str_pad($countWeek, 2, 0, STR_PAD_LEFT);
													$corDay = date('w', strtotime($currentDate));
													
													if ( $countWeek != "" ) {
														if ($corDay == $b) {
															if ( date('Y-m-d', strtotime($_POST['petsa2'])) == $currentDate ) {
																$activeDay = "activeDay";
															}

															else {
																$activeDay = "";
															}

															if ( $b <= 3 ) {
																$tooltipPos = "tooltip-right";
															}

															else {
																$tooltipPos = "tooltip-left";
															}

															?>
																<td class="calendar_Cell <?php echo $activeDay; ?>" id="<?php echo $currentDate; ?>" style="padding: 2px !important;">
																	<div class="tooltips" style="width: 100%;">
																		<?php echo $countWeek; ?>
																		<!-- <idv class="tooltiptext <?php echo $tooltipPos; ?>">
																			<div class="panel panel-default">
																				<div class="panel-heading">
																					<b>List of evets for <?php echo date('F d, Y', strtotime($currentDate)) ?></b>
																				</div>

																				<div class="panel-body schedules">
																					<span style="color: #333;">Loading. Please wait.</span>
																				</div>
																			</div> -->
																			<!-- <button class="btn btn-primary btn-block"> <span class="fa fa-plus"></span> CREATE EVENT</button> -->
																		<!-- </idv> -->
																	</div>
																	<div class="schedules" style="height: 180px !important;overflow-y: auto !important;">
																		<?php 
																			$sql = "SELECT eventid,actTitle,starttime,endtime,statdate,enddate FROM event_dayactivity  WHERE '".date('Y-m-d', strtotime($currentDate))."' BETWEEN statdate AND enddate ORDER BY starttime ASC";
																			$result = mysql_query($sql,$connection) or die(mysql_error());
																			while ( $row = mysql_fetch_array($result)) {
																			 	echo '<p class="alert alert-success"><b>'.ucfirst($row['actTitle']).'</b> ('.date('h:i A',strtotime($row['starttime'])).' - '.date('h:i A',strtotime($row['endtime'])).')</p>';
																			 } 
																		?>
																		
																	</div>
																</td>
															<?php
															if ( $countWeek < date('t', strtotime($_POST['petsa'])) && $countWeek != "" ) {
																$countWeek ++;
															}

															else {
																$countWeek = "";
															}
															
														}

														else {
															?>
																<td class="calendar_Cell" style="background-color: #ffe;"></td>
															<?php

														}
													}

													else {
														?>
															<td class="calendar_Cell" style="background-color: #ffe;"></td>
														<?php

													}
												}
											?>
										</tr>
									<?php
								}
							?>
						</tbody>
					</table>
				</div>
			<?php
		break;
	}
?>

				