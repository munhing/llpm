$('#myModal').on('show.bs.modal', function (e) {

    $title = $(e.relatedTarget).attr('data-title');
    $(this).find('.modal-title').text($title);

    $title = $(e.relatedTarget).attr('data-body');
    $(this).find('.modal-body').text($title);             

    var form = $(e.relatedTarget).closest('form');
    $(this).find('.modal-footer #confirm').data('form', form);
});

$('#myModal').find('.modal-footer #confirm').on('click', function(){
    $(this).data('form').submit();
});

$('.select-select2').select2({
    allowClear: true,
    placeholder: "Select Country"
    
});

function select2Plugin(inputName, url, defaultValue, nullStatement)
{
	$(inputName).select2({
		minimumInputLength: 4,
		ajax: {
			url: url,
			quietMillis: 1000,
			type: 'GET',
			data: function (term, page) {
				return {
					q:term
				};
			},
			results: function (data, page) {
				console.log(data);
				return {
					results: data
				};
			}
		},
		initSelection: function(element, callback) {

			console.log(defaultValue);
			console.log(callback);
	        // the input tag has a value attribute preloaded that points to a preselected repository's id
	        // this function resolves that id attribute to an object that select2 can render
	        // using its formatResult renderer - that way the repository name is shown preselected
	        if (defaultValue !== "") {
	            $.ajax(url + "?q=" + defaultValue, {
	                dataType: "json"
	            }).done(function(data) {
	            	console.log(data[0]);
	            	callback(data[0]); 
	            });
	        } else {
	        	callback({'id':null, 'text':nullStatement})
	        }
	    },
	});
}