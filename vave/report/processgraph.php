<?php
echo "
<script>
function init_echarts() {

	if( typeof (echarts) === 'undefined'){ return; }
	console.log('init_echarts');

	var theme = {
		color: [
			'#3498DB','#9B59B6','#26B99A', '#34495E', 
			'#BDC3C7','#8abb6f','#759c6a', '#bfd3b7'
		],

		title: {
			itemGap: 8,
			textStyle: {
				fontWeight: 'normal',
				color: '#3498DB'
			}
		},

		dataRange: {
			color: ['#1f610a', '#97b58d']
		},

		toolbox: {
			color: ['#408829', '#408829', '#408829', '#408829']
		},

		tooltip: {
			backgroundColor: 'rgba(0,0,0,0.8)',
			axisPointer: {
				type: 'line',
				lineStyle: {
					color: '#408829',
					type: 'dashed'
				},
				crossStyle: {
					color: '#408829'
				},
				shadowStyle: {
					color: 'rgba(200,200,200,0.3)'
				}
			}
		},

		grid: {
			borderWidth: 0
		},

		categoryAxis: {
			axisLine: {
				lineStyle: {
					color: '#408829'
				}
			},
			splitLine: {
				lineStyle: {
					color: ['#eee']
				}
			}
		},

		valueAxis: {
			axisLine: {
				lineStyle: {
					color: '#408829'
				}
			},
			splitArea: {
				show: true,
				areaStyle: {
					color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
				}
			},
			splitLine: {
				lineStyle: {
					color: ['#eee']
				}
			}
		},

		textStyle: {
			fontFamily: 'Arial, Verdana, sans-serif'
		}
	};

	if ($('#reportgraph').length ){

		var echartBar = echarts.init(document.getElementById('reportgraph'), theme);

		echartBar.setOption({
			title: {
				text: 'Total Proposal Approved by TMC: $totalTMC',
				subtext: 'Total Proposal from TMMIN: $totalTMMIN'
			},
			tooltip: {
				trigger: 'axis'
			},
			legend: {
				data: ['TMMIN Proposal', 'TMC Approved']
			},
			toolbox: {
				show: false
			},
			calculable: false,
			xAxis: [{
				type: 'category',
				data: [";

				for($i=0; $i<$modelIndex; $i++){
					$modelcost = $model[$i][0];

					echo "'$modelcost',";
				}

				echo "]
			}],
			yAxis: [{
				type: 'value'
			}],
			series: [{
				name: 'TMMIN Proposal',
				type: 'bar',
				itemStyle: {
					normal: {
						label : {
							show: true, position: 'top',
							formatter: function(params){
								return Number(params.value).toLocaleString('en-US'); 
							}
						}
					}
				},
				data: [";

				for($i=0; $i<$modelIndex; $i++){
					$eacost = $model[$i][1];

					echo "'$eacost',";
				}

				echo "],

				markLine: { 
					itemStyle: {
						normal: {
							label : {
								show: true, 
								formatter: function(params){
									return Number(params.value).toLocaleString('en-US'); 
								}
							}
						}
					},                 	
					data: [{
						type: 'average',
						name: 'Average'
					}]
				}
			},{
				name: 'TMC Approved',
				type: 'bar',
				itemStyle: {
					normal: {
						label : {
							show: true, position: 'top',
							formatter: function(params){
								return Number(params.value).toLocaleString('en-US'); 
							}
						}
					}
				},
				data: [";

				for($i=0; $i<$modelIndex; $i++){
					$tmccost = $model[$i][2];

					echo "'$tmccost',";
				}

				echo "],
				markLine: {
					itemStyle: {
						normal: {
							label : {
								show: true, 
								formatter: function(params){
									return Number(params.value).toLocaleString('en-US'); 
								}
							}
						}
					},  
					data: [{
						type: 'average',
						name: 'Average'
					}]
				}
			}]
		});

	}
}

</script>";
?>