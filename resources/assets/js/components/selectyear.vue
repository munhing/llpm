<template>
	<select name="{{ name }}" class="{{ class }}">
		<option v-for="y in optYear" :value="y">{{ y }}</option>
	</select>	
</template>

<script>

	import moment from 'moment';

	export default {

		props: {
			name: {type: String, default: 'year'},
			class: {type: String, default: 'form-control'}
		},
		data: function() {
			return {
				selected: moment().year(),
				optYear: []
			}
		},
		methods: {
			getYears: function() {
				let years = [];
				let yearBegin = 2016;
				// let yearEnd = 2020;
				let yearEnd = moment().year();

				console.log(yearBegin);
				console.log(yearEnd);

				// let yearEnd = moment().format('YYYY');
				for(var i=yearBegin; i<=yearEnd; i++) {
					years.push(i);
				}
				return years;
			}
		},
		created: function() {
			this.optYear = this.getYears();
			console.log(this.optYear);
		}	
	};
	
</script>