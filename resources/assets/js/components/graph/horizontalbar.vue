<template>
	<canvas :width="width" :height="height"></canvas>
</template>

<script>
	
	import Chart from 'chart.js';

	export default {
		props: {
			title: {default: 'Give a title'},
			labels: {},
			value: {},
			valueLabel: {default: 'Label 1'},
			fillColor: {default: 'rgba(255, 99, 132, 0.2)'},
			borderColor: {default: 'rgba(255,99,132,1)'},
			width: {default: '600'},
			height: {default: '400'},
			responsive: {default: false}
		},

		ready() {

			console.log(this.valueLabel);
			console.log(this.responsive);

			var data = {
				labels: this.labels,
				datasets: [
					{
						label: this.valueLabel,
						backgroundColor: this.fillColor,
						borderColor: this.borderColor,
						borderWidth: 1,
						data: this.value			
					}									
				]
			}

		    var opt = {
		        events: false,
		        showTooltips: false,
		        responsive: this.responsive,
		        title: {display: true, text: this.title},
                animation: {
                    onComplete: function () {
                        var chartInstance = this.chart;
                        var ctx = chartInstance.ctx;
                        ctx.textAlign = "center";
                        ctx.font = "10px Verdana";
                        ctx.fillStyle = "#FF0000";
                        Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                ctx.fillText(dataset.data[index], bar._model.x + 20, bar._model.y - 5);                        
                            }),this)
                        }),this);
                    }
                }
		    };

			new Chart(this.$el.getContext('2d'), {
				type: "horizontalBar",
				data: data,
				options: opt
			});
		}
	}
	
</script>