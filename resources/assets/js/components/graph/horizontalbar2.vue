<template>
	<canvas :width="width" :height="height"></canvas>
</template>

<script>
	
	import Chart from 'chart.js';

	export default {
		props: {
			title: {default: 'Give a title'},
			labels: {},
			value1: {},
			value1Label: {default: 'Label 1'},
			value2: {},
			value2Label: {default: 'Label 2'},
			fillColor1: {default: 'rgba(255, 99, 132, 0.2)'},
			borderColor1: {default: 'rgba(255,99,132,1)'},
			fillColor2: {default: 'rgba(54, 162, 235, 0.2)'},
			borderColor2: {default: 'rgba(54, 162, 235, 1)'},
			width: {default: '600'},
			height: {default: '400'},
			responsive: {default: false}
		},

		ready() {

			console.log(this.value1Label);
			console.log(this.value2Label);
			console.log(this.responsive);

			var data = {
				labels: this.labels,
				datasets: [
					{
						label: this.value1Label,
						backgroundColor: this.fillColor1,
						borderColor: this.borderColor1,
						borderWidth: 1,
						data: this.value1				
					},
					{
						label: this.value2Label,
						backgroundColor: this.fillColor2,
						borderColor: this.borderColor2,
						borderWidth: 1,
						data: this.value2
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
                                ctx.fillText(dataset.data[index], bar._model.x + 40, bar._model.y - 5);                        
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