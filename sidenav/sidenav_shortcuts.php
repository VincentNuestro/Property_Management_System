<div class="sidebar-shortcuts" id="sidebar-shortcuts">
	<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
		<!-- <button class="btn btn-success" title="View Calendar" onclick='checkaccessfirst("<?php echo "tcalendar"; ?>");'>
			<i class="ace-icon fa fa-calendar-o"></i>
		</button>

		<button class="btn btn-info" title="View Reports" onclick="selectnav(11)">
			<i class="ace-icon fa fa-pie-chart"></i>
		</button>

		<button class="btn btn-warning" title="View LCA Units" onclick='checkaccessfirst("<?php echo "fplca"; ?>");'>
			<i class="ace-icon fa fa-map-marker"></i>
		</button>

		<button class="btn btn-danger" title="View SET Units" onclick='checkaccessfirst("<?php echo "fpset"; ?>");'>
			<i class="ace-icon fa fa-map-o"></i>
		</button> -->
		<button class="btn btn-success btn-round" title="End Of Day" onclick="fncEOD();">
			<i class="ace-icon fa fa-calendar bigger-130"></i>
		</button>

		<button class="btn btn-primary btn-round" title="X & Z Reading" onclick="showoption();">
			<i class="ace-icon fa fa-file-text-o bigger-130"></i>
		</button>

		<button class="btn btn-warning btn-round" title="Mall Scheduler" onclick="ShowSchedOption();"> 
			<i class="ace-icon fa fa-calendar-plus-o bigger-130"></i>
		</button>

		<button class="btn btn-danger btn-round" title="View Memo" onclick="viewmemotab();">
			<i class="ace-icon fa fa-envelope bigger-130"></i>
		</button>
	</div>
	<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
		<span class="btn btn-success btn-round"></span>

		<span class="btn btn-info btn-round"></span>

		<span class="btn btn-warning btn-round"></span>

		<span class="btn btn-danger btn-round"></span>
	</div>
</div>

<?php include("zxreading/index.php"); ?>
