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