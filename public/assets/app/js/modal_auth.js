var submitCount = 0;

// authSubmit();

$('input[data-confirm], button[data-confirm]').on('click', function(e){

    e.preventDefault();

    var thisBut = $(this);
    var thisForm = thisBut.closest('form'); // get the real form
    var but = $('input[data-submit-form], button[data-submit-form]'); // get the modal-auth submit button

    but.data('form', thisForm); // update modal-auth submit button's data-submit-form with the form's id to be submitted

    $('.modal-auth').modal('show');
});

// function authSubmit() {

    $('input[data-auth], button[data-auth]').on('click', function(e){
    	
        e.preventDefault();

        var submitForm = true;
        var baseUrl = window.location.origin;

        console.log(baseUrl);

        thisBut = $(this);

        // console.log(thisBut.data('submit-form'));

        // ajax to check on the password is correct
        var formData = $('.form-password').serialize();
        var pwd = $('#auth_password').val();

        var closestForm = $(this).closest('form');

        console.log(thisBut.data('form'));

        submitForm = validatePassword(pwd);
        
        if(submitForm) {

            $.ajax({
                url: baseUrl + "/authenticate",
                type: 'POST',
                data: formData,
                success: function(data) {
                    // console.log(data);
                    // alert(data);

                    if (data == 1) {
                        submitCount++;
                        console.log(submitCount);
                        // submit form
                         // $('#' + thisBut.data('submit-form')).submit();
                         if(submitCount == 1) {
                            thisBut.data('form').submit();
                         }
                    } else {
                        alert('Password is Incorrect!');
                        // authSubmit();
                    }              

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }

    });
// }

function validatePassword(password)
{

    // must not be blank
    if(password.trim() == "") {
        alert("No password entered!");
        return false;    
    }

    return true;
    
}