var Vue = require('vue');
var DatepickerComponent = require('./vue-components/Datepicker.js')

new Vue({
    el:"#app",
    components: {
        datepicker: DatepickerComponent
    }
});