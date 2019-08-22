<style lang="stylus">

	$header-height = 100px;
	$day-size = 41px;

	.datepicker {
	    position: absolute;
	    top: 100%;
	    width: 315px;
	    z-index: 5;
	    background-color: #fff;
	    box-shadow: 0 14px 45px rgba(0,0,0,.25),0 10px 18px rgba(0,0,0,.22);
	}

	.datepicker__header {
		background-color: #0097a7;
		color: #fff;
		padding: 20px;
		height: $header-height;
	}

	.datepicker__year {
	    position: relative;
	    overflow: hidden;
	    opacity: .7;
	    height: 16px;
	    margin-bottom: 10px;
	    line-height: 16px;		
	}

	.datepicker__date {
	    position: relative;
	    overflow: hidden;
	    height: 32px;
	    font-size: 32px;
	    line-height: 32px;		
	}

	.datepicker__week {
		font-size: 12px;
		line-height: 12px;
		color: rgba(0,0,0,0.8);
		padding: 0 14px;
	}

	.datepicker__weekday {
		float: left;
		width: $day-size;
		text-align: center;
	}

	.datepicker__days {
	    position: relative;
	    overflow: hidden;
	    margin: 14px 14px 0;
	    height: $day-size * 5;
	    -webkit-transition: height .3s;
	    transition: height .3s;		
	}

	.datepicker__days.has-6-weeks {
	    height: $day-size * 6;
	}

	.datepicker__day {
	    position: relative;
	    width: $day-size;
	    height: $day-size;
	    float: left;
	    text-align: center;
	    line-height: $day-size;
	    cursor: pointer;
	    -webkit-transition: color .45s cubic-bezier(.23,1,.32,1) 0ms;
	    transition: color .45s cubic-bezier(.23,1,.32,1) 0ms;		
	}

	.datepicker__day__text {
		position: relative;
	}

	.datepicker__day__effect {
	    position: absolute;
	    top: 2px;
	    left: 2px;
	    width: 36px;
	    height: 36px;
	    border-radius: 50%;
	    background-color: #0097a7;
	    transition: all .45s cubic-bezier(.23,1,.32,1) 0ms;
	    transform: scale(0);
	    opacity: 0;
	}

	.datepicker__day:hover {
		color: #fff;

		.datepicker__day__effect {
			transform: scale(1);
			opacity: 0.6;
		}
	}	

	.datepicker__day.selected {
		color: #fff;

		.datepicker__day__effect {
			transform: scale(1);
			opacity: 1;
		}
	}		

	.datepicker__controls {
		position: relative;
	    height: 56px;
	    line-height: 56px;
	    text-align: center;
	}	

	.datepicker__month {
	    position: absolute;
	    height: 16px;
	    line-height: 16px;
	    overflow: hidden;
	    top: 20px;
	    left: 0;
	    right: 0;
	    bottom: 0;
	}

	.datepicker__controls {
		position: relative;
	    height: 56px;
	    line-height: 56px;
	    text-align: center;
	}
	
	.datepicker__controls button {
	    position: relative;
	    border: none;
	    background-color: transparent;
	    -webkit-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;
	    outline: none;
	    cursor: pointer;
	    width: 56px;
	    height: 56px;
	}

	.datepicker__controls svg {
	    width: 24px;
	    height: 24px;
	    fill: rgba(0,0,0,.87);
	    vertical-align: middle;
	}
	.datepicker__next {
	    float: right;
	}

	.datepicker__prev {
	    float: left;
	}

	.datepicker__actions {
	    text-align: right;
	    padding: 8px;
	}

	.datepicker__actions button {
	    border: none;
	    background-color: transparent;
	    display: inline-block;
	    cursor: pointer;
	    outline: none;
	    color: #00bcd4;
	    font-size: 14px;
	    text-transform: uppercase;
	    font-weight: 500;
	    min-width: 88px;
	    line-height: 36px;
	    text-align: center;
	    -webkit-appearance: none;
	    -webkit-transition: all .3s;
	    transition: all .3s;
	}

	.datepicker__actions button:hover {
		background-color: rbga(153,153,153,0.2);
	}

	.datepicker-slide-transition {
		opacity: 1;
		transition: all 0.3s;
		transform: translateY(0);
	}

	.datepicker-slide-leave, .datepicker-slide-enter {
		opacity: 0;
		transform: translateY(-15px);
	}

</style>

<template>
	<div class="datepicker" v-if="visible" transition="datepicker-slide" @click.stop>
		<div class="datepicker__header">
			<div class="datepicker__year">
				{{ year }}
			</div>
			<div class="datepicker__date">
				{{ date_formatted }}
			</div>
		</div>
		<div class="datepicker__controls">
			<div class="datepicker__month">{{ month.getFormatted() }}</div>
			<button class="datepicker__next" @click="nextMonth()">
				<svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"></path></svg>
			</button>
			<button class="datepicker__prev" @click="prevMonth()">
				<svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"></path></svg>
			</button>
		</div>
		<div class="datepicker__week">
			<div v-for="day in days" track-by="$index" class="datepicker__weekday">
				{{ day }}
			</div>
		</div>
		<div class="datepicker__days" :class="classWeeks">
			<div class="datepicker__day" :style="{width: (month.getWeekStart() * 41) + 'px' }">
			</div>
			<div class="datepicker__day" @click="selectDate(day)" v-for="day in month.getDays()" :class="{selected: isSelected(day)}">
				<span class="datepicker__day__effect"></span>
				<span class="datepicker__day__text">{{ day.format('D') }}</span>
			</div>
		</div>
		<div class="datepicker__actions">
			<button @click="cancel">Cancel</button>
			<button @click="submit">Ok</button>
		</div>
	</div>

</template>

<script>

import Month from '../../modules/month';

export default {
   props: {
   		date: {},
   		visible: {type: Boolean, default: false}
   },
   data: function() {
   		console.log(this.date.toString());
   		console.log(this.date.date());
   		console.log(this.date.month());
   		console.log(this.date.year());
   		return {
   			days: ['S','M','T','W','T','F','S'],
   			month: new Month(this.date.month(), this.date.year())
   		}
   },
   methods: {
   		isSelected: function(day) {
   			return this.date.unix() === day.unix();
   		},
   		selectDate: function(day) {
   			this.date = day.clone();
   		},
   		nextMonth: function() {
   			let month = this.month.month + 1;
   			let year = this.month.year;

   			if (month > 11) {
   				year += 1;
   				month = 0;
   			}
   			this.month = new Month(month, year);
   		},
   		prevMonth: function() {
   			let month = this.month.month - 1;
   			let year = this.month.year;

   			if (month < 0) {
   				year -= 1;
   				month = 11;
   			}
   			this.month = new Month(month, year);
   		},
   		submit: function() {
   			this.$dispatch('change', this.date);
   		},
   		cancel: function() {
   			this.$dispatch('cancel');
   		}
   },
   computed: {
   		year: function() {
   			return this.date.format('YYYY');
   		},
   		classWeeks: function(){
   			return 'has-' + this.month.getWeeks() + '-weeks';
   		},
   		date_formatted: function() {
   			return this.date.format('ddd, DD MMM')
   		}
   }
}
</script>

