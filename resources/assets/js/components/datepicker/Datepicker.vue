<style>
	.datepicker__container{
		position: relative;
	}
</style>

<template>
	<div class="datepicker__container">
		<input type="text" value="{{ date_formatted }}" @click="showDatepicker">
		<input type="hidden" value="{{ date_raw }}" name="{{ name }}">
		<datepicker-agenda :date="date" :visible="isVisible" @change="selectDate" @cancel="hideDatepicker"></datepicker-agenda>
	</div>
</template>

<script>
import moment from 'moment';
import DatepickerAgenda from './DatepickerAgenda.vue';

export default {
	components: {
		'datepicker-agenda': DatepickerAgenda
	},
	props: {
		value: {type: String, required: true},
		format: {type: String, default: 'YYYY-MM-DD'},
		name: {type: String}
	},
	data: function(){
		return {
			isVisible: false,
			date: moment(this.value, 'YYYY-MM-DD')
		}
	},
	methods: {
		selectDate: function(date) {
			this.date = date;
			this.isVisible = false;
		},
		showDatepicker: function() {
			this.isVisible = true;
			setTimeout(()=>document.addEventListener('click', this.hideDatepicker), 0);
		},
		hideDatepicker: function() {
			this.isVisible = false;
			document.removeEventListener('click', this.hideDatepicker);
		}
	},
	computed: {
		date_formatted: function(){
			return this.date.format(this.format)
		},
		date_raw: function(){
			return this.date.format('YYYY-MM-DD')
		}
	}
}
</script>
