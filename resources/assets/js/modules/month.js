import moment from 'moment';
import 'moment-range';

export default class Month {

	constructor(month, year) {
		let date = moment([year, month]);
		console.log(date.toString());
		this.start = moment([year, month]);
		this.end = this.start.clone().endOf('month');
		this.month = month;
		this.year = year;
	}

	getWeekStart() {
		return this.start.weekday();
	}

	getWeeks() {
		return this.end.week() - this.start.week() + 1;
	}

	getDays() {
		return moment.range(this.start, this.end).toArray('days');
	}

	getFormatted() {
		return this.start.format('MMMM YYYY');
	}
}