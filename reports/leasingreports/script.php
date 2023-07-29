<script type="text/javascript">

	$(function(){
		loadMall();
		sampleHeatGraph();
		byFloorsGraph();
	});

	$('#mallUnits').change(function(){
		sampleHeatGraph();
	});

	$('#floorMall').change(function(){
		byFloorsGraph();
	});

	function loadMall(){
		$.ajax({
			type:'POST',
			async:false,
			url: 'mainclass.php',
			data: 'form=tblref_mall', 
			success:function(data){
				$('.listMall').html( data );   
			}
		});
	}

	function byFloorsGraphData(){
		var dataHolder = "";
		$.ajax({
			type:'POST',
			async:false,
			url:'reports/leasingreports/class.php',
			data: 'mallid=' + $('#floorMall').val() + '&form=byFloorsGraph', 
			success:function(data){
				dataHolder = data;    
			}
		}); 
		return dataHolder 
	}

	function byFloorsGraph(){
		var datas = byFloorsGraphData();
		Highcharts.chart('byFloorsGraph', {

		    chart: {
		        type: 'column'
		    },

		    exporting: { enabled: true },

		    title: {
		        text: ''
		    },

		    xAxis: { 
		    	title:{
		        	text:'Floor'
		        }
		    },

		    yAxis: {
		    	title:{
		    		text: 'Total Units'
		    	}
		    },
		    credits:{
		    	enabled : false
		    },

		    tooltip: {
		        formatter: function () {
		            return '<b>' + this.series.data[this.x].name + ':</b> '+ this.series.data[this.x].y +' <br>';
		        }
		    },
		    series : JSON.parse( datas )

		});
	}

	function OccupiedUnits(){
		var dataHolder = "";
		$.ajax({
			type:'POST',
			async:false,
			url:'reports/leasingreports/class.php',
			data: 'mallid=' + $('#mallUnits').val() + '&form=OccupiedUnits', 
			success:function(data){
				dataHolder = data;    
			}
		}); 
		return dataHolder 
	}

	function sampleHeatGraph(){

		var datas = OccupiedUnits();
		$('#sampleHeat').css('height',datas.split('##')[1]+'px');
		$('#sampleHeat').css('width',datas.split('##')[3]);

		Highcharts.chart('sampleHeat', {

		    chart: {
		        type: 'heatmap',
	            marginTop: 40,
	            marginBottom: 40
		    },

			exporting: {
		        buttons: {
		            contextButton: {
		                align: 'left',
		                x: 0,
		                y: 0,
		                verticalAlign: 'top',
		                text: 'Print'
		            }
		        }
		    },

		    title: {
		        text: ''
		    },

		    xAxis: { 
		    	title:{
		        	text:'Units'
		        }
		    },

		    yAxis: {
		    	categories: JSON.parse( datas.split('##')[2] ),
		    	title:{
		    		text: 'Floor'
		    	}
		    },

		    colorAxis: {
		        min: 0,
		        minColor: '#FFFFFF',
		        maxColor: Highcharts.getOptions().colors[0]
		    },
		    credits:{
		    	enabled : false
		    },
		    legend: {
		        align: 'right',
		        layout: 'vertical',
		        margin: 0,
		        verticalAlign: 'top',
		        y: 25,
	            symbolHeight: 320
		    },

		    tooltip: {
		        formatter: function () {
		        	var stat = "";
		        	if( this.point.stat == 2 ){
		        		stat = "Occupied";
		        	} else if( this.point.stat == 1 ) {
		        		stat = "Reserved";
		        	} else {
		        		stat = "Vacant";
		        	}
		            return '<b>' + this.series.name + ':</b> '+ stat +' <br>';
		        }
		    },
		    series : JSON.parse( datas.split('##')[0] )

		});
		$('#sampleHeat .highcharts-legend-item').css('display','none');
	}
</script>