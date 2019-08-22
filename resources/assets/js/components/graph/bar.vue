<template>
	<canvas width="600" height="400"></canvas>
</template>

<script>
	
	import Chart from 'chart.js';

	export default {
		props: {
			title: {default: 'Give a title'},
			labels: {},
			value: {},
			valueLabel: {default: 'Label'},
			fillColor: {default: 'rgba(255, 99, 132, 0.2)'},
			borderColor: {default: 'rgba(255,99,132,1)'}
		},

		ready() {

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
		        responsive: false,
		        title: {display: true, text: this.title},
                animation: {
                    onComplete: function () {
                        var chartInstance = this.chart;
                        var ctx = chartInstance.ctx;
                        ctx.textAlign = "center";
                        ctx.fillStyle = "#FF0000";
                        Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                ctx.fillText(dataset.data[index], bar._model.x, bar._model.y - 15);                        
                            }),this)
                        }),this);
                    }
                }
		    };

			new Chart(this.$el.getContext('2d'), {
				type: "bar",
				data: data,
				options: opt
			});
		}
	}
	
</script>