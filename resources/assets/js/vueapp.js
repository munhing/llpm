
import Vue from 'vue';
import VueResource from 'vue-resource';
import Keen from 'keen-ui';

Vue.use(VueResource);
Vue.use(Keen);

new Vue({
	el: 'body',
	data: function() {
		return {
			workorders: [],
			workorder_id: ''
		}
	},
	methods: {
		alert: function() {
			alert('Hello World!');
		}
	},
	watch: {
		workorder_id: function() {
			this.$http.get('/vue/api?q=' + this.workorder_id).then((response) => {
			    this.workorders = response.data;
			  }, (response) => {
			    // error callback
			  });			
		}
	}
});