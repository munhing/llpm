import Vue from 'vue';
import VueResource from 'vue-resource';
import moment from 'moment';

Vue.use(VueResource);

Vue.directive('dialog', {
	bind: function() {

	}
});

Vue.filter('round', function(value, decimals) {
	if(!value) {
		value = 0;
	}

	if(!decimals) {
		decimals = 0;
	}
	value = parseFloat(value).toFixed(2);
	// value = Math.round(value * Math.pow(10, decimals)) / Math.pow(10, decimals);
	return value;
});

var paginator = Vue.extend({
	template: `
		<div v-show="pagination.total > 0" class="pull-right">
		    <button class="btn btn-default btn-sm btn-circle" @click="prevPage"
		            :disabled="(pagination.current_page == 1)">&laquo;
		    </button>			
		    <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span>
		    <button class="btn btn-default btn-sm btn-circle" @click="nextPage"
		            :disabled="(pagination.current_page == pagination.last_page)">&raquo;
		    </button>
		</div>
		<pre v-show="showPaginatorInfo">{{ pagination | json }}</pre>
		<pre v-show="showPaginatorInfo">{{ resource | json }}</pre>
	`,
	props: {
		name: {type:String, required:true},
		url: {type:String, required:true},
		resource: {required: true, twoWay: true},
		query: {required: true, twoWay: true},
		showPaginatorInfo: {default: false},
		minQueryLength: {type:Number, default:4}
	},
	data: function() {
		return {
			pagination:{
                total: 0,
                per_page: 0,
                current_page: 0,
                last_page: 0,
                from: 0,
                to: 0				
			}
		}
	},
	ready: function() {
		// this.fetch();
	},
	events: {
		'search': function(name) {
			if(name == this.name) {
				this.fetch();
			}
		}
	},
	methods: {
		fetch: function(page = 1) {
			if(this.query.length < this.minQueryLength) {
				return false;
			}
			this.$http.get(this.url + '?query=' + this.query.trim() + '&page=' + page).then((response) => {
			    console.log(response.data);
			    this.resource = JSON.parse(response.data);
			    this.makePagination(this.resource);
			  }, (response) => {
			    // error callback
			  });
		},
		makePagination: function(data) {
		    let pagination = {
                total: data.total,
                per_page: data.per_page,
                current_page: data.current_page,
                last_page: data.last_page,
                from: data.from,
                to: data.to
            }

            this.$set('pagination', pagination);
		},
		nextPage: function() {
			let page = this.pagination.current_page + 1;
			this.fetch(page);
			console.log(page);
		},
		prevPage: function() {
			let page = this.pagination.current_page - 1;
			this.fetch(page);
			console.log(page);
		}			
	}
});

new Vue({
	el: '#app',
	components: {
		paginator
	},
	data: function() {
		return {
			query_workorder: '',
			query_container: '',
			query_cargo: '',
			query_manifest: '',
			data_workorder: {},
			data_container: {},
			data_cargo: {},
			data_manifest: {},
			base_url:''
		}
	},
	ready: function() {
		this.base_url = document.getElementById('base_url').value;
	},
	methods: {
		search_workorder: function() {
			this.$broadcast('search', 'workorder');
		},
		search_container: function() {
			this.$broadcast('search', 'container');
		},	
		search_cargo: function() {
			this.$broadcast('search', 'cargo');
		},			
		search_manifest: function() {
			this.$broadcast('search', 'manifest');
		},			
		dateFormat: function(date) {
			return moment(date).format('DD/MM/YYYY');
		},
		cargoLink: function(data) {
			if(data.import_vessel_schedule_id == 0) {
				return this.base_url + "/admin/manifest/schedule/" + data.export_vessel_schedule_id + "/export/cargoes/" + data.id + "/show";
			}

			return this.base_url + "/admin/manifest/schedule/" + data.import_vessel_schedule_id + "/import/cargoes/" + data.id + "/show";
		}
	}
	
});

