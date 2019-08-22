<script>
    export default {
        events: {
            onSubmit: function(e) {
                console.log(e);
                let el = e.currentTarget;
                let url = el.getAttribute('action');
                let year = el.querySelectorAll('[name=year]')[0].value;
                console.log(url);
                console.log(year);
                window.open(url + '?year=' + year, "_newtab");
            }
        },

        ready: function() {
            console.log('I am Ready');
        },

        created: function() {
            console.log('this component has been created');
        }
    }
</script>
    
